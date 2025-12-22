<x-common.component-card title="Radio Buttons">
    <div class="flex flex-wrap items-center gap-8">
        <div x-data="{ checkboxToggle: false }">
            <label for="radioLabelOne"
                class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none">
                <div class="relative">
                    <input type="checkbox" id="radioLabelOne" class="sr-only" @change="checkboxToggle = !checkboxToggle" />
                    <div :class="checkboxToggle ? 'border-brand-500 bg-brand-500' :
                        'bg-transparent border-gray-300'"
                        class="hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                        <span class="h-2 w-2 rounded-full"
                            :class="checkboxToggle ? 'bg-white' : 'bg-white'"></span>
                    </div>
                </div>
                Default
            </label>
        </div>

        <div x-data="{ checkboxToggle: true }">
            <label for="radioLabelTwo"
                class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none">
                <div class="relative">
                    <input type="checkbox" id="radioLabelTwo" class="sr-only"
                        @change="checkboxToggle = !checkboxToggle" />
                    <div :class="checkboxToggle ? 'border-brand-500 bg-brand-500' :
                        'bg-transparent border-gray-300'"
                        class="hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                        <span class="h-2 w-2 rounded-full"
                            :class="checkboxToggle ? 'bg-white' : 'bg-white'"></span>
                    </div>
                </div>
                Secondary
            </label>
        </div>

        <div x-data="{ checkboxToggle: false }">
            <label for="radioLabelThree"
                class="flex cursor-pointer items-center text-sm font-medium text-gray-300 select-none">
                <div class="relative">
                    <input type="checkbox" id="radioLabelThree" class="peer sr-only"
                        @change="checkboxToggle = !checkboxToggle" disabled />
                    <div :class="checkboxToggle ? 'bg-transparent border-gray-300' :
                        'border-brand-500 bg-brand-500'"
                        class="mr-3 flex h-5 w-5 items-center justify-center rounded-full border-[1.25px]">
                        <span class="h-2 w-2 rounded-full"
                            :class="checkboxToggle ? 'bg-white' : 'bg-white'"></span>
                    </div>
                </div>
                Disabled Secondary
            </label>
        </div>
    </div>
</x-common.component-card>
