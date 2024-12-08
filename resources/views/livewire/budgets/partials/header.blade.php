<section class="grid grid-cols-2 gap-1 px-4 sm:px-8">
    <div
        class="lg:col-span-1 col-span-2"
        x-data="{
            addresses: @entangle('addresses'),
            get dp_min_date(){
                try{
                    return moment(this.addresses[this.addresses.length-1].back_date)
                        .add(1, 'day')
                        .format('Y-M-D');
                }catch{
                    return null;
                }
            },
            get dp_max_date(){
                try{
                    return moment(this.addresses[this.addresses.length-1].back_date)
                        .add(1, 'month')
                        .format('Y-M-D');
                }catch{
                    return null;
                }
            }
        }"
    >
        <x-datepicker
            :disabled="!$hasPermissionToManage"
            :startIcon="@svg('heroicon-o-calendar')"
            lang="budgets.input-date"
            wire:model="budgetForm.finish_at" type="date"
        />
    </div>
    <x-textfield
        :disabled="!$hasPermissionToManage"
        :startIcon="@svg('heroicon-o-banknotes')"
        :root="['class' => 'lg:col-span-1 col-span-2']"
        lang="budgets.input-value"
        wire:model="budgetForm.value" type="number"
    />
</section>
