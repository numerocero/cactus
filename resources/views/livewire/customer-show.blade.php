@php use App\Constants\RouteNames; @endphp
<div x-data="{showCreate: false, showUpdate: false}" x-on:customer-updated="showUpdate = false">
    <div class="card mb-5 mt-5">
        <form wire:submit="update">
            <h5 class="card-header">Customer: {{$customer->name}}</h5>
            <div class="card-body">
                <dl>
                    <dt>Name</dt>
                    <dd x-show="!showUpdate">{{$customer->name}}</dd>
                    <input type="text" class="form-control" id="nameInput" wire:model="name" x-show="showUpdate">
                    <dt>Email</dt>
                    <dd x-show="!showUpdate">{{$customer->email}}</dd>
                    <input type="text" class="form-control" id="emailInput" wire:model="email" x-show="showUpdate">
                    <dt>Last interaction date</dt>
                    <dd>{{$customer->interactions?->first()?->created_at}}</dd>
                </dl>
            </div>
            <div class="card-body" x-show="!showUpdate">
                <a class="btn" href="{{URL::route(RouteNames::WEB_DASHBOARD)}}">< Back</a>
                <a class="btn btn-outline-secondary" x-on:click="showUpdate = true; showCreate = false">Update</a>
                <a class="btn btn-outline-secondary" x-on:click="showCreate = !showCreate">New Interaction</a>
            </div>
            <div class="card-body text-end" x-show="showUpdate">
                <a class="btn btn-outline-secondary" x-on:click="showUpdate = false">Cancel</a>
                <button type="submit" class="btn btn-primary fw-bold">Save</button>
            </div>
        </form>
    </div>

    <div x-show="showCreate" x-on:interaction-created="showCreate = false">
        <livewire:customer.interaction-create :customer="$customer"></livewire:customer.interaction-create>
    </div>

    <livewire:customer.interaction-index :customer="$customer"></livewire:customer.interaction-index>
</div>
