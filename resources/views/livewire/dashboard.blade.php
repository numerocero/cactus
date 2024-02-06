@php use App\Constants\RouteNames; @endphp
<div>
    <div class="card mb-5 mt-5" >
        <h5 class="card-header">New Customer</h5>
        <div class="card-body">
            <form wire:submit="store">
                <div class="mb-3">
                    <label for="nameInput" class="form-label">Name</label>
                    <input type="text" class="form-control" id="nameInput" wire:model="name">
                    @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Email</label>
                    <input type="text" class="form-control" id="emailInput" wire:model="email">
                    @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary fw-bold" >Save</button>
                </div>

            </form>
        </div>
    </div>
    <div class="card mb-5 mt-5" >
        <h5 class="card-header">Customers</h5>
        <ul class="list-group list-group-flush">
            @foreach ($customers as $customer)
                <li class="list-group-item">
                    <div class="row g-0">
                        <div class="col-md-10">
                            <a class="text-black text-decoration-none" href="{{URL::route(RouteNames::WEB_CUSTOMER_SHOW, $customer)}}">
                                <p class="mb-0">{{$customer->name}}</p>
                                <small>{!! $customer->interactions?->first()?->created_at ?? "&nbsp;" !!}</small>
                            </a>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-outline-danger btn-sm" wire:click="delete('{{$customer->getRouteKey()}}')">Delete</button>
                        </div>
                    </div>
            @endforeach
        </ul>

        {{$customers->links('pagination::bootstrap-4')}}

    </div>

</div>
