<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Fundraising') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                
                <form method="POST" action="{{route('admin.fundraisings.update', $fundraising)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$fundraising->name}}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" />
                        <img src="{{Storage::url($fundraising->thumbnail)}}" alt="" class="rounded-2xl object-cover w-[200px] h-[150px]">
                        <x-text-input id="thumbnail" class="block mt-1 w-full" type="file" name="thumbnail" autofocus autocomplete="thumbnail" />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="target_amount_display" :value="__('Target Amount')" />
                        <x-text-input id="target_amount_display" class="block mt-1 w-full" type="text" value="Rp{{number_format($fundraising->target_amount, 0, ',', '.')}}" required autofocus autocomplete="off" />
                        <input id="target_amount" type="hidden" name="target_amount" :value="{{$fundraising->target_amount}}" />
                        <x-input-error :messages="$errors->get('target_amount')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        
                        <select name="category_id" id="category_id" class="py-3 rounded-lg pl-3 w-full border border-slate-300">
                            <option value="">{{$fundraising->category->name}}</option>
                            @foreach($categories as $category)
                                @if($category->id != $fundraising->category_id)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <textarea name="about" id="about" cols="30" rows="5" class="border border-slate-300 rounded-xl w-full">{{$fundraising->about}}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Fundraising
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const targetAmountDisplay = document.getElementById('target_amount_display');
        const targetAmount = document.getElementById('target_amount');
        
        targetAmountDisplay.addEventListener('input', function (e) {
            const value = targetAmountDisplay.value.replace(/[^,\d]/g, '').toString();
            const split = value.split(',');
            let rupiah = split[0].substr(0, split[0].length % 3);
            const ribuan = split[0].substr(split[0].length % 3).match(/\d{3}/gi);

            if (ribuan) {
                const separator = rupiah ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            targetAmountDisplay.value = 'Rp' + rupiah;

            targetAmount.value = parseInt(value.replace(/\D/g, '')) || 0;
        });
    });
</script>