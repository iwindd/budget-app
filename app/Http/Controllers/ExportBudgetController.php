<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetAddress;
use App\Models\BudgetCompanion;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PA\ProvinceTh\Factory;

class ExportBudgetController extends Controller
{
    public function document(Request $request, Budget $budget)
    {
        $user = $budget->user;
        $owner = $budget->user;
        $related = $budget->companions;
        $ofId    = $request->get('of');

        $companions = $related->where('user_id', '!=', $ofId);
        $of         = $related->where('user_id', $ofId)->first();

        if ($of){
            $fakeCompanion = new BudgetCompanion();
            $fakeCompanion->user_id = $user->id;
            $fakeCompanion->budget_id = $budget->id;
            $companions->push($fakeCompanion);
            $user = $of->user;
        }

        $addresses    = $budget->addresses()->get(['multiple', 'from_id', 'back_id', 'from_date', 'back_date']);
        $addressesRaw = Budget::getExtractAddresses($addresses->toArray());
        $addressesMinimizedDocument = Budget::getMinimizedAddresses($addressesRaw, ['plate', 'distance', 'show_as']);
        // ไม่จำเป็นต้องเช็ค plate, distance, show_as ในหน้านี้

        $pdf = Pdf::loadView('exports.document.index', [
            'serial' => $budget->serial,
            'date' => $budget->date,
            'owner' => $owner->name,
            'name' => $user->name,
            'value' => $budget->value,
            'office' => $budget->office->label,
            'invitation' => $budget->invitation->label,
            'order' => $budget->order,
            'order_at' => $budget->date,
            'position' => $user->position->label,
            'owner_position' => $user->position->label,
            'affiliation' => $user->affiliation->label,
            'companions' => $companions,
            'header' => $budget->header,
            'subject' => $budget->subject,
            'addresses' =>  $addressesMinimizedDocument,
            'locations' => BudgetAddress::list(),
            'hours' => Budget::getTotalHours($budget),
            'expenses' => Budget::getSummaryExpenses($budget),
            'defaultExpense' => Expense::createDefaultBudgetItemExpense($budget)
        ]);

        return $pdf->stream();
    }

    public function evidence(Budget $budget) {
        $expenses = Budget::getExpenses($budget)
            ->where('merge', false)
            ->where('default', false)
            ->get(['id', 'label', 'merge']);
        $expenses->push(Expense::getDefault(['id', 'label', 'merge', 'default']));

        $users = $budget->companions;
        $owner = new BudgetCompanion();
        $owner->user_id = $budget->user_id;
        $owner->budget_id = $budget->id;
        $users->prepend($owner);

        $pdf = PDF::loadView('exports.evidence.index', [
            'office' => $budget->office->label,
            'province' => Factory::province()->find($budget->office->province)['name_th'],
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
            'value' => $budget->value,
            'expenses' => $expenses,
            'budgetExpenses' => $budget->expenses,
            'users' => $users,
            'serial' => $budget->serial,
            'date' => $budget->finish_at
        ]);
        $pdf->set_paper('a4', 'landscape');
        return $pdf->stream();
    }

    public function certificate(Budget $budget) {
        $pdf = PDF::loadView('exports.certificate.index', [
            'office' => $budget->office->label,
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
            'header' => $budget->header,
            'addresses' => Budget::getExtractAddresses($budget->addresses->toArray()),
            'locations' => BudgetAddress::list(),
            'subject' => $budget->subject
        ]);

        return $pdf->stream();
    }

    public function travel(Budget $budget) {
        $addresses = Budget::getExtractAddresses($budget->addresses->toArray());
        $pdf = PDF::loadView('exports.travel.index', [
            'invitation' => $budget->invitation->label,
            'province' => Factory::province()->find($budget->office->province)['name_th'],
            'name' => $budget->user->name,
            'position' => $budget->user->position->label,
            'start' =>  $addresses[0]['from_date'],
            'end' => $addresses[count($addresses)-1]['back_date'],
            'header' => $budget->header,
            'addresses' => $addresses
        ]);
        $pdf->set_paper('a4', 'landscape');

        return $pdf->stream();
    }
}
