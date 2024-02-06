<div class="mt-5">
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    <form>
        <div class="mb-3">
            <label for="emailInput" class="form-label">Email :</label>
            <input type="text" id="emailInput" wire:model="email" class="form-control">
            @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="passwordInput" class="form-label">Password :</label>
            <input type="password" id="passwordInput" wire:model="password" class="form-control">
            @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary fw-bold" wire:click.prevent="login">Login</button>
        </div>
    </form>
</div>
