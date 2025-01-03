@extends('layouts.myapp')
@section('content')
<div class="mx-auto max-w-screen-xl ">
    <div class=" bg-white rounded-md p-6 my-12 justify-center">
        <form action="{{ route('allReservations') }}" method="get" class="w-full">
            @csrf
            <div>
                <input type="text" name="username" value="{{ $username ?? '' }}" class="bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5" placeholder="search by username">

                <select name="status" class="mt-3 bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5">
                    <option value="">Status</option>
                    <option value="Active" {{ isset($status) && $status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Pending" {{ isset($status) && $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Finished" {{ isset($status) && $status == 'Finished' ? 'selected' : '' }}>Finished</option>
                    <option value="Cancelled" {{ isset($status) && $status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select name="payment_status" class="mt-3 bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block w-full p-2.5">
                    <option value="">Payment status</option>
                    <option value="Active" {{ isset($payment_status) && $payment_status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Pending" {{ isset($payment_status) && $payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Finished" {{ isset($payment_status) && $payment_status == 'Finished' ? 'selected' : '' }}>Finished</option>
                    <option value="Cancelled" {{ isset($payment_status) && $payment_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <div class="mt-3">
                    <div><label for=""><strong>Reservation date</strong></label></div>
                    <div class="flex mt-2">
                        <input type="date" name="date_ini" value="{{ $date_ini ?? '' }}" class="mr-2 w-1/2 bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block p-2.5" placeholder="Reservation date initial">
                        <input type="date" name="date_end" value="{{ $date_end ?? '' }}" class="ml-2 w-1/2 bg-pr-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pr-500 focus:border-pr-500 block p-2.5" placeholder="Reservation date finish">
                    </div>
                </div>
                <div class="mt-3 flex justify-end">
                    <button class="p-3 font-bold border rounded-md border-pr-400 text-pr-400 hover:text-white hover:bg-pr-400"> search </button>
                </div>
            </div>
        </form>
        <div class="w-full">
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap overflow-scroll table-auto">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Client</th>
                                <th class="px-4 py-3 w-48">Car</th>
                                <th class="px-4 py-3 w-24">Started at</th>
                                <th class="px-4 py-3 w-24">End at</th>
                                <th class="px-4 py-3">Duration</th>
                                <th class="px-4 py-3 w-26">Raimining days</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Paiment Status</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 ">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">


                            @forelse ($reservations as $reservation)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                            <img loading="lazy" class="object-cover w-full h-full rounded-full"
                                                src="{{ $reservation->user->avatar }}" alt=""
                                                loading="lazy" />
                                            <div class="absolute inset-0 rounded-full shadow-inner"
                                                aria-hidden="true"></div>
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $reservation->user->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $reservation->user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $reservation->car->brand }} {{ $reservation->car->model }}

                                </td>

                                <td class="px-4 py-3  text-sm">
                                    {{ Carbon\Carbon::parse($reservation->start_date)->format('y-m-d') }}
                                </td>
                                <td class="px-4 py-3  text-sm">
                                    {{ Carbon\Carbon::parse($reservation->end_date)->format('y-m-d') }}
                                </td>

                                <td class=" text-xs">
                                    <p class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->diffInDays(Carbon\Carbon::parse($reservation->start_date)) }}
                                        days
                                    </p>
                                </td>


                                <td class="px-4 py-3 text-xs">
                                    @if ($reservation->start_date > Carbon\Carbon::now())
                                    <p class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->diffInDays(Carbon\Carbon::now()) }}
                                        days
                                    </p>
                                    @else
                                    <span class="px-4 py-3 text-sm">
                                        {{ Carbon\Carbon::parse($reservation->end_date)->diffInDays(Carbon\Carbon::now()) }}
                                        days
                                    </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $reservation->car->price_per_day * $reservation->days }} $
                                </td>


                                <td class="px-4 py-3 text-sm ">
                                    @if ($reservation->payment_status == 'Pending')
                                    <span
                                        class="p-2 text-white rounded-md bg-yellow-300 ">{{ $reservation->payment_status }}</span>
                                    @elseif ($reservation->payment_status == 'Canceled')
                                    <span
                                        class="p-2 text-white rounded-md bg-red-500 ">{{ $reservation->payment_status }}</span>
                                    @elseif ($reservation->payment_status == 'Paid')
                                    <span
                                        class="p-2 text-white rounded-md bg-green-500 px-5">{{ $reservation->payment_status }}</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-sm ">
                                    @if ($reservation->status == 'Pending')
                                    <span
                                        class="p-2 text-white rounded-md bg-yellow-300 ">{{ $reservation->status }}</span>
                                    @elseif ($reservation->status == 'Ended')
                                    <span
                                        class="p-2 text-white rounded-md bg-black ">{{ $reservation->status }}</span>
                                    @elseif ($reservation->status == 'Active')
                                    <span
                                        class="p-2 text-white rounded-md bg-green-500 px-4">{{ $reservation->status }}</span>
                                    @elseif ($reservation->status == 'Canceled')
                                    <span
                                        class="p-2 text-white rounded-md bg-red-500 ">{{ $reservation->status }}</span>
                                    @endif
                                </td>


                                <td class="px-4 py-3 w-36 text-sm flex flex-col justify-center">

                                    <a class="p-2 mb-1 text-white bg-pr-500 hover:bg-pr-400 font-medium rounded text-center"
                                        href="{{ route('editStatus', ['reservation' => $reservation->id]) }}">
                                        <button>Edit Status </button>
                                    </a>

                                    <a class="p-2 mb-1 text-white bg-indigo-500 hover:bg-indigo-600 font-medium rounded text-center"
                                        href="{{ route('editPayment', ['reservation' => $reservation->id]) }}">
                                        <button>Edit payment </button>
                                    </a>

                                </td>

                            </tr>
                            @empty
                            @endforelse


                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center my-12 w-full">
                    {{ $reservations->links('pagination::tailwind') }}
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
