@extends('front.layouts.app')

@push('after-style')
<script type="text/javascript"
		src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{config('midtrans.clientKey')}}"></script>
@endpush

@section('content')
<section class="max-w-[640px] w-full min-h-screen mx-auto flex flex-col bg-[#FCF7F1] overflow-x-hidden">
    <div class="header flex flex-col overflow-hidden h-[220px] relative">
        <nav class="pt-5 px-3 flex justify-between items-center relative z-20">
            <div class="flex items-center gap-[10px]">
                <a href="{{route('front.details', $fundraising) }}" class="w-10 h-10 flex shrink-0">
                    <img src="{{ asset('assets/images/icons/back.svg') }}" alt="icon">
                </a>
            </div>
            <div class="flex flex-col items-center text-center">
                <p class="font-semibold text-sm">Checkout</p>
            </div>
            <a href="#" class="w-10 h-10 flex shrink-0">
                <img src="{{ asset('assets/images/icons/menu-dot.svg') }}" alt="icon">
            </a>
        </nav>
        <div class="flex items-center px-4 my-auto gap-[14px]">
            <div class="w-[90px] h-[100px] flex shrink-0 rounded-2xl overflow-hidden relative">
                <img src="{{ Storage::url($fundraising->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                <p class="w-[90px] h-[23px] bg-[#4541FF] text-center p-[4px_12px] absolute bottom-0 font-bold text-[10px] leading-[15px] text-white">VERIFIED</p>
            </div>
            <div class="flex flex-col gap-1">
                <p class="font-bold leading-[22px]">{{ $fundraising->name }}</p>
                <p class="text-xs leading-[18px]">Target <span class="font-bold text-[#FF7815]">Rp{{ number_format($fundraising->target_amount, 0, ',', '.') }}</span></p>
            </div>
        </div>
    </div>

    <div class="flex flex-col z-30">
        <div id="content" class="w-full min-h-[calc(100vh-220px)] h-full bg-white rounded-t-[40px] flex flex-col gap-[30px] p-[30px_24px_30px]">

            <h1 class="text-center font-extrabold text-[24px] leading-[36px]">Confirm Your Information</h1>

            <h1 class="text-center font-extrabold text-[24px] leading-[36px]">Selected Amount</h1>

            <div class="flex justify-center bg-blue-500 text-white p-3 rounded-xl text-sm">
                <span class="font-bold text-lg">Rp {{number_format($donatur->total_amount, 0, ',', '.') }}</span>
            </div>
            <hr class="border-dashed">

            <!-- Display Submitted Data -->
            <div class="flex flex-col gap-[10px] w-full">
                <p class="font-semibold text-sm">Your Name</p>
                <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300">
                    <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/user.svg') }}" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <input type="text" class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400" value="{{$donatur->name}}" readonly>
                </div>
            </div>

            <div class="flex flex-col gap-[10px] w-full">
                <p class="font-semibold text-sm">No. WhatsApp</p>
                <div class="flex items-center w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300">
                    <div class="mr-[10px] w-6 h-6 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/call.svg') }}" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <input type="number" class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400" value="{{$donatur->phone_number}}" readonly>
                </div>
            </div>

            <div class="flex flex-col gap-[10px] w-full">
                <p class="font-semibold text-sm">Your Notes</p>
                <div class="flex items-start w-full px-4 py-2 rounded-md shadow-sm ring-1 ring-inset ring-gray-300">
                    <div class="mt-2 mr-2 w-6 h-6 flex items-center justify-center">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}" class="h-full w-full object-contain" alt="icon">
                    </div>
                    <textarea name="notes" id="notes" class="w-full border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400" cols="30" rows="4" readonly>{{$donatur->notes}}</textarea>
                </div>
            </div>
        <button id="pay-button" class="p-[14px_20px] bg-[#76AE43] rounded-full text-white w-full mx-auto font-semibold hover:shadow-[0_12px_20px_0_#76AE4380] transition-all duration-300 text-nowrap text-center">
            Pay
        </button>
        </div>
    </div>
    <div id="snap-container"></div>
</section>
@endsection

@push('after-script')
<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
      // Also, use the embedId that you defined in the div above, here.
      snap.pay('{{$snapToken}}', {
        onSuccess: function (result) {
          /* You may add your own implementation here */
          location.href = '/invoice/{{$donatur->id}}';
          alert("payment success!"); console.log(result);
        },
        onPending: function (result) {
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
        },
        onError: function (result) {
          /* You may add your own implementation here */
          alert("payment failed!"); console.log(result);
        },
        onClose: function () {
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      });
    });
  </script>
@endpush