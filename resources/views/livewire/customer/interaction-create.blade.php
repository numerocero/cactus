<div class="card mt-5">
    <h5 class="card-header">New interaction for {{$customer->name}}</h5>
    <div class="card-body">
        <form wire:submit="store">
            <div class="mb-3">
                <label for="descriptionInput" class="form-label">Description :</label>
                <textarea class="form-control" id="descriptionInput" rows="2" wire:model="description"></textarea>
                @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary fw-bold" >Save</button>
            </div>
        </form>
    </div>
</div>
