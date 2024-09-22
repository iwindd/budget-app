<section class="grid grid-cols-4 gap-2">
  <section class="space-y-2">
    <x-form.label for="header" :value="__('budgets.input-address-from')" />

    <select class="location-selector w-full outline-none" name="from"></select>
  </section>
  <section class="space-y-2">
    <x-form.label for="office" :value="__('budgets.input-address-from-datetime')" />

    <x-form.input id="office" name="office" type="datetime-local" class="block w-full" />
  </section>
  <section class="space-y-2">
    <x-form.label for="header" :value="__('budgets.input-address-back')" />
    <select class="location-selector w-full outline-none" name="to"></select>
  </section>
  <section class="space-y-2">
    <x-form.label for="office" :value="__('budgets.input-address-back-datetime')" />

    <x-form.input id="office" name="office" type="datetime-local" class="block w-full" />
  </section>
</section>