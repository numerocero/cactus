@php use App\Constants\RouteNames; @endphp
<div class="card mb-5 mt-5" x-data="{update: false}" x-on:interaction-updated="update = false">
    <form wire:submit="update">
        <h5 class="card-header">Interaction</h5>
        <div class="card-body">
            <dl>
                <dt>Description</dt>
                <dd x-show="!update">{{$interaction->description}}</dd>
                <textarea
                    class="form-control" id="descriptionInput" rows="2" wire:model="description" x-show="update"
                ></textarea>
                <dt>Created at</dt>
                <dd>{{$interaction->created_at}}</dd>
            </dl>
        </div>
        <div class="card-body" x-show="!update">
            <a class="btn" href="{{URL::route(RouteNames::WEB_CUSTOMER_SHOW, $customer)}}">< Back</a>
            <a class="btn btn-outline-secondary" x-on:click="update = !update">Update</a>
        </div>
        <div class="card-body text-end" x-show="update">
            <a class="btn btn-outline-secondary" x-on:click="update = false">Cancel</a>
            <button type="submit" class="btn btn-primary fw-bold">Save</button>
        </div>
    </form>
</div>
