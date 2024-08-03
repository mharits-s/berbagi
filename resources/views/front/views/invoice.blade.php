@extends('front.layouts.app')

@section('content')
<section class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#FCF7F1] overflow-x-hidden">
    <div class="header flex flex-col overflow-hidden h-[220px] relative">
        <nav class="pt-5 px-3 flex justify-center relative z-20">
    
            <div class="flex flex-col items-center  text-center">
                <p class="font-semibold text-sm">Invoice</p>
            </div>
        </nav>
        <div class="flex items-center px-4 my-auto gap-[14px]">
            <div class="w-[90px] h-[100px] flex shrink-0 rounded-2xl overflow-hidden relative">
                <img src="{{ Storage::url($donatur->fundraising->thumbnail) }}" href="{{route('front.details', $donatur->fundraising)}}" class="w-full h-full object-cover" alt="thumbnail">
                <p class="w-[90px] h-[23px] bg-[#4541FF] text-center p-[4px_12px] absolute bottom-0 font-bold text-[10px] leading-[15px] text-white">VERIFIED</p>
            </div>
            <div class="flex flex-col gap-1">
                <p class="font-bold leading-[22px]">{{ $donatur->fundraising->name }}</p>
                <p class="text-xs leading-[18px]">Target <span class="font-bold text-[#FF7815]">Rp{{ number_format($donatur->fundraising->target_amount, 0, ',', '.') }}</span></p>
            </div>
        </div>
    </div>

    <div class="flex flex-col z-30">
        <div id="content" class="w-full min-h-[calc(100vh-220px)] h-full bg-white rounded-t-[40px] flex flex-col gap-[30px] p-[30px_24px_30px]">

            <h1 class="text-center font-extrabold text-[24px] leading-[36px]">Your Invoice<br>Order ID #{{$donatur->id}}</h1>
            <div class="flex flex-col-2 justify-between items-center gap-x-5">
                <h2 class="text-center font-bold">Total Amount</h2>
                <div class="flex justify-center bg-blue-500 text-white p-3 rounded-xl text-sm">
                    <span class="font-bold text-lg">Rp {{number_format($donatur->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="flex flex-col-2 justify-between items-center gap-x-5">
                <h2 class="text-center font-bold">Status Payment</h2>
                @if($donatur->is_paid)
                <div class="flex justify-center bg-green-500 text-white py-3 px-6 rounded-xl text-sm">
                    <span class="font-bold text-lg">Paid</span>
                </div>
                @else
                <div class="flex justify-center bg-red-500 text-white py-3 px-6 rounded-xl text-sm">
                    <span class="font-bold text-lg">Unpaid</span>
                </div>
                @endif
            </div>
            <hr class="border-dashed">

            <!-- Display Submitted Data -->
            <div class="flex flex-col gap-[10px] w-full">
                <p class="font-semibold text-sm">Your Name</p>
                <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 bg-gray-100">
                    <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/user.svg') }}" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <p class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900">{{$donatur->name}}</p>
                </div>
            </div>
            <div class="flex flex-col gap-[10px] w-full">
                <p class="font-semibold text-sm">No. Whatsapp</p>
                <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 bg-gray-100">
                    <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/call.svg') }}" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <p class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900">{{$donatur->phone_number}}</p>
                </div>
            </div>
            <div class="flex flex-col gap-[10px] w-full">
                <p class="font-semibold text-sm">Notes</p>
                <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 bg-gray-100">
                    <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <p class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900">{{$donatur->notes}}</p>
                </div>
            </div>
            <a href="{{route('front.details', $donatur->fundraising)}}"  class="p-[14px_20px] bg-[#76AE43] rounded-full text-white w-full mx-auto font-semibold hover:shadow-[0_12px_20px_0_#76AE4380] transition-all duration-300 text-nowrap text-center">
                    Return to Details
            </a>
        </div>
    </div>
    <div id="snap-container"></div>
</section>
@endsection