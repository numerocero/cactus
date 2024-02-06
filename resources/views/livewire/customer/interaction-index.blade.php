@php use App\Constants\RouteNames;use App\Constants\RouteParameters; @endphp
<div class="card mb-5 mt-5">
    <h5 class="card-header">Interactions</h5>
    <ul class="list-group list-group-flush">
        @foreach ($interactions as $interaction)
            <li class="list-group-item" wire:key="{{ $interaction->getRouteKey() }}">
                <div class="row">
                    <div class="col-md-10">
                        <a
                            class="text-black text-decoration-none"
                            href="{{URL::route(RouteNames::WEB_CUSTOMER_INTERACTION_SHOW, [RouteParameters::CUSTOMER=>$customer, RouteParameters::INTERACTION=>$interaction])}}"
                        >
                            <p class="mb-0">{{$interaction->description}}</p>
                            <small>{{$interaction->created_at}}</small>
                        </a>
                    </div>
                    <div class="col-md-2 text-end">
                        <button
                            class="btn btn-outline-danger btn-sm" wire:click="delete('{{$interaction->getRouteKey()}}')"
                        >Delete
                        </button>
                    </div>
                </div>

            </li>
        @endforeach
    </ul>

    {{$interactions->links('pagination::bootstrap-4')}}
</div>
