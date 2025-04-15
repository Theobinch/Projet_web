<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="card">
        <div class="card-header" id="auth_password">
            <h3 class="card-title">
                Password
            </h3>
        </div>
        <div class="card-body grid gap-5">
            <div class="w-full">
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        Current Password
                    </label>
                    <input class="input" name="current_password" placeholder="Your current password" type="password" value="">
                    </input>
                </div>
            </div>
            <div class="w-full">
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        New Password
                    </label>
                    <input class="input" name="password" placeholder="New password" type="password" value="">
                    </input>
                </div>
            </div>
            <div class="w-full">
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        Confirm New Password
                    </label>
                    <input class="input" name="password_confirmation" placeholder="Confirm new password" type="password" value="">
                    </input>
                </div>
            </div>

            <div class="flex justify-end pt-2.5">
                <button class="btn btn-primary">
                    Reset Password
                </button>
            </div>
        </div>
    </div>
</form>
