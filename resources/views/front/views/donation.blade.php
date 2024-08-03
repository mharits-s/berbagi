@extends('front.layouts.app')
@section('content')
    <section class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#FCF7F1] overflow-x-hidden">
        <div class="header flex flex-col overflow-hidden h-[220px] relative">
            <nav class="pt-5 px-3 flex justify-between items-center relative z-20">
                <div class="flex items-center gap-[10px]">
                    <a href="{{route('front.details', $fundraising)}}" class="w-10 h-10 flex shrink-0">
                        <img src="{{asset('assets/images/icons/back.svg')}}" alt="icon">
                    </a>
                </div>
                <div class="flex flex-col items-center text-center">
                    <p class="font-semibold text-sm">#SendSupport</p>
                </div>
                <a href="" class="w-10 h-10 flex shrink-0">
                    <img src="{{asset('assets/images/icons/menu-dot.svg')}}" alt="icon">
                </a>
            </nav>
            <div class="flex items-center px-4 my-auto gap-[14px]">
                <div class="w-[90px] h-[100px] flex shrink-0 rounded-2xl overflow-hidden relative">
                    <img src="{{Storage::url($fundraising->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail">
                    <p class="w-[90px] h-[23px] bg-[#4541FF] text-center p-[4px_12px] absolute bottom-0 font-bold text-[10px] leading-[15px] text-white">VERIFIED</p>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-bold leading-[22px]">{{($fundraising->name)}}</p>
                    <p class="text-xs leading-[18px]">Target <span class="font-bold text-[#FF7815]">Rp{{number_format($fundraising->target_amount, 0, ',', '.')}}</span></p>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col z-30">
            <div id="content" class="w-full min-h-[calc(100vh-220px)] h-full bg-white rounded-t-[40px] flex flex-col gap-[30px] p-[30px_24px_30px]">

            <form action="{{ route('front.checkout', $fundraising->slug) }}" method="GET" class="flex flex-col gap-5">
                @csrf
                    <h1 class="text-center font-extrabold text-[24px] leading-[36px]">Choose Amount <br>You Want to Donate</h1>

                    <div class="grid grid-cols-2 w-fit mx-auto justify-center gap-5">
                    <input required type="hidden" id="amount" name="amount" value="">
                        <button data-amount="15000" type="button" class="donation-button flex flex-col rounded-xl gap-4 p-4 items-center border border-gray-200 group bg-white group-hover:from-cyan-500 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:focus:ring-cyan-800 " onclick="setActive(this)">
                            <div class="w-10 h-10 flex shrink-0 overflow-hidden">
                                <img src="{{ asset('assets/images/icons/cool.svg') }}" alt="icon">
                            </div>
                            <span class="font-bold text-lg">Rp 15.000</span>
                        </button>
                        <button data-amount="50000" type="button" class="donation-button flex flex-col rounded-xl gap-4 p-4 items-center border border-gray-200 group bg-white group-hover:from-cyan-500 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:focus:ring-cyan-800 " onclick="setActive(this)">
                            <div class="w-10 h-10 flex shrink-0 overflow-hidden">
                                <img src="{{ asset('assets/images/icons/smile.svg') }}" alt="icon">
                            </div>
                            <span class="font-bold text-lg">Rp 50.000</span>
                        </button>
                        <button data-amount="250000" type="button" class="donation-button flex flex-col rounded-xl gap-4 p-4 items-center border border-gray-200 group bg-white group-hover:from-cyan-500 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:focus:ring-cyan-800 " onclick="setActive(this)">
                            <div class="w-10 h-10 flex shrink-0 overflow-hidden">
                                <img src="{{ asset('assets/images/icons/love.svg') }}" alt="icon">
                            </div>
                            <span class="font-bold text-lg">Rp 250.000</span>
                        </button>
                        <button data-amount="500000" type="button" class="donation-button flex flex-col rounded-xl gap-4 p-4 items-center border border-gray-200 group bg-white group-hover:from-cyan-500 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:focus:ring-cyan-800 " onclick="setActive(this)">
                            <div class="w-10 h-10 flex shrink-0 overflow-hidden">
                                <img src="{{ asset('assets/images/icons/cool.svg') }}" alt="icon">
                            </div>
                            <span class="font-bold text-lg">Rp 500.000</span>
                        </button>
                        <button data-amount="700000" type="button" class="donation-button flex flex-col rounded-xl gap-4 p-4 items-center border border-gray-200 group bg-white group-hover:from-cyan-500 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:focus:ring-cyan-800 " onclick="setActive(this)">
                            <div class="w-10 h-10 flex shrink-0 overflow-hidden">
                                <img src="{{ asset('assets/images/icons/smile.svg') }}" alt="icon">
                            </div>
                            <span class="font-bold text-lg">Rp 700.000</span>
                        </button>
                        <button data-amount="1000000" type="button" class="donation-button flex flex-col rounded-xl gap-4 p-4 items-center border border-gray-200 group bg-white group-hover:from-cyan-500 group-hover:to-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-500 dark:focus:ring-cyan-800 " onclick="setActive(this)">
                            <div class="w-10 h-10 flex shrink-0 overflow-hidden">
                                <img src="{{ asset('assets/images/icons/love.svg') }}" alt="icon">
                            </div>
                            <span class="font-bold text-lg">Rp 1.000.000</span>
                        </button>
                    </div>
                    <hr class="border-dashed">

                    <h1 class="text-center font-extrabold text-[24px] leading-[36px]">Fill Your Information</h1>
                    
                    <div class="flex flex-col gap-[10px] w-full">
                        <p class="font-semibold text-sm">Your Name</p>
                        <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:text-sm transition-all duration-300">
                            <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                                <img src="{{asset('assets/images/icons/user.svg')}}" class="h-full w-full object-contain" alt="icon">
                            </div>
                            <input required type="text" class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0" placeholder="What’s your name?" name="name">
                        </div>
                    </div>

                    <div class="flex flex-col gap-[10px] w-full">
                        <p class="font-semibold text-sm">No. WhatsApp</p>
                        <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:text-sm transition-all duration-300">
                            <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                                <img src="{{asset('assets/images/icons/call.svg')}}" class="h-full w-full object-contain" alt="icon">
                            </div>
                            <input required type="number" class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0" placeholder="Write phone number" name="phone_number">
                        </div>
                    </div>

                    <div class="flex flex-col gap-[10px] w-full relative">
                        <p class="font-semibold text-sm">Your Notes</p>
                        <div class="flex items-start w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:text-sm transition-all duration-300">
                            <div class="mt-2 mr-2 w-6 h-6 flex items-center justify-center">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="h-full w-full object-contain" alt="icon">
                            </div>
                            <textarea required name="notes" id="notes" class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0" cols="30" rows="4" placeholder="Write your beautiful message"></textarea>
                        </div>
                    </div>

                <button type="submit" class="p-[14px_20px] bg-[#76AE43] rounded-full text-white w-full mx-auto font-semibold hover:shadow-[0_12px_20px_0_#76AE4380] transition-all duration-300 text-nowrap text-center">
                    Checkout
                </button>
                </form>

                
                
                
                    
            </div>
        </div>
        
    </section>
@endsection 

@push('before-script')
<script>
    function setActive(button) {
        // Get the amount from the button's data attribute
        var amount = button.getAttribute('data-amount');
        
        // Update the hidden input value
        document.getElementById('amount').value = amount;
        
        // Remove active class from all buttons
        var buttons = document.querySelectorAll('.donation-button');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Add active class to the selected button
        button.classList.add('active');
    }
    document.querySelector('form').addEventListener('submit', function(event) {
        var amount = document.getElementById('amount').value;
        if (!amount || amount < 15000) {
            alert('Please select a valid donation amount.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
@endpush