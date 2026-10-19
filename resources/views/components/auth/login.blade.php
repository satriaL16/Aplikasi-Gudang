<div>
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('login') }}"><b>Souko</b>-APP</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masuk untuk memulai sesi</p>

                <form wire:submit="login">
                    <div class="input-group mb-3">
                        <input wire:model="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" autocomplete="username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <small class="d-block text-danger mb-2">{{ $message }}</small>
                    @enderror

                    <div class="input-group mb-3">
                        <input wire:model="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <small class="d-block text-danger mb-2">{{ $message }}</small>
                    @enderror

                    <div class="row">
                        <div class="col-7">
                            <div class="icheck-primary">
                                <input wire:model="remember" type="checkbox" id="remember">
                                <label for="remember">Ingat saya</label>
                            </div>
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-block"
                                wire:loading.attr="disabled" wire:target="login">
                                <span wire:loading.remove wire:target="login">Masuk</span>
                                <span wire:loading wire:target="login">Memproses...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>