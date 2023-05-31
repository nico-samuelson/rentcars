@extends('user.layouts.main')

<style>
    .header {
        border-radius: 15pt !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        height: 150px;
    }

    .profile-picture {
        display: block !important;
        width: 100px !important;
        aspect-ratio : 1/1 !important;
        border-radius: 50%;
        padding: 0 !important;
        margin: 100px auto !important;
    }

    .toast {
        bottom: 20px;
        z-index: 5001;
    }

    #hidePass, #showPass {
        right: 15px;
        top: 35px;
    }

    #hidePass {
        display: none;
    }
</style>

@section('container')
    <div class="container py-4">
        <div class="row justify-content-center mt-md-0 mt-5 p-md-5 p-3">
            <div class="col-md-6 tile border">
                <div class="row header bg-primary-300 position-relative mb-5">
                    <img src="/storage/website-assets/default-profile.png" class="profile-picture" alt="Profile Picture">
                </div>

                <div class="p-3 mt-5">
                    <div class="row mt-3" id="edit_profile_form">
                        <div class="col-6">
                            <input type="text" readonly class="form-control-plaintext fw-bold fs-4" id="name" name="name" value="{{ ucwords(auth()->user()->name) }}">

                            <p class="text-muted">Joined {{ date_format(new Datetime(auth()->user()->created_at), 'M Y') }}</p>
                        </div>

                        {{-- Edit Button --}}
                        <div class="col-6 d-flex justify-content-end align-items-start action_btn p-0" role="group">
                            <button class="btn" id="edit_btn" type="button" onclick="edit()">
                                <i class="fa-solid fa-pencil fa-lg"></i>
                            </button>
                        </div>

                        <hr>
                        <h5 class="fw-semibold my-4">Personal Information</h5>
                        
                        <div class="mb-3">
                            <label for="birth_date" class="form-label fw-semibold mb-0">Birth Date</label>
                            <input type="date" readonly class="form-control-plaintext" id="birth_date" name='birth_date' value="{{ auth()->user()->birth_date }}">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold mb-0">Phone Number</label>
                            <input type="text" readonly class="form-control-plaintext" id="phone" name='phone' value="{{ auth()->user()->phone }}">
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label fw-semibold mb-0">City</label>
                            <input type="text" readonly class="form-control-plaintext" id="city" name='city' value="{{ auth()->user()->city }}">
                        </div>

                        <hr>

                        <h5 class="fw-semibold my-4">Account Credentials</h5>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold mb-0">Email</label>
                            <input type="text" readonly class="form-control-plaintext" id="email" name='email' value="{{ auth()->user()->email }}">
                        </div>
            
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-9">
                                    <label for="password" class="form-label fw-semibold mb-0">Password</label>
                                    <input type="password" readonly class="form-control-plaintext" id="password" name="password" value="apaaninihayo">
                                </div>
                                <div class="col-3 d-flex justify-content-end align-items-start">
                                    <button class="btn btn-outline-primary" type="button" id='changePassword' data-bs-toggle="modal" data-bs-target="#changePassModal">Change</button>
                                </div>
                            </div>
                        </div>
    
                        <hr>
                        <div class="d-flex justify-content-end my-4">
                            <form action="{{ route('delete.account') }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger fw-semibold" type="submit">Delete Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notif Toasts --}}
    <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='successUpdate' role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-center text-success fw-semibold">
            Your data has been updated successfully!
        </div>
    </div>

    <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='failedUpdate' role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-center text-danger fw-semibold">
            Failed to update data, please check your input and try again!
        </div>
    </div>

    @if(session()->has('changePassFailed'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='changePassFailed' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                {{ session()->get('changePassFailed') }}
            </div>
        </div>
        <button class="btn visually-hidden" onclick="showToast('changePassFailed')" id="toastBtn"></button>

    @elseif(session()->has('invalidPass'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='invalidPass' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                {{ session()->get('invalidPass') }}
            </div>
        </div>
        <button class="btn visually-hidden" onclick="showToast('invalidPass')" id="toastBtn"></button>

    @elseif(session()->has('changeRestricted'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='changeRestricted' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                {{ session()->get('changeRestricted') }}
            </div>
        </div>
        <button class="btn visually-hidden" onclick="showToast('changeRestricted')" id="toastBtn"></button>

    @elseif(session()->has('ongoingRent'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='ongoingRent' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                {{ session()->get('ongoingRent') }}
            </div>
        </div>
        <button class="btn visually-hidden" onclick="showToast('ongoingRent')" id="toastBtn"></button>
    
    @elseif(session()->has('errorDelete'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='errorDelete' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                {{ session()->get('errorDelete') }}
            </div>
        </div>
        <button class="btn visually-hidden" onclick="showToast('errorDelete')" id="toastBtn"></button>
    @endif

    {{-- Change Pass Modal --}}
    <div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="changePassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('user.changePass') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changePassModalLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body p-3">
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label fw-semibold mb-0">Current Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <i class="fa-solid fa-eye position-absolute" id="showPass"></i>
                                <i class="fa-solid fa-eye-slash position-absolute" id="hidePass"></i>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="newPass" class="form-label fw-semibold mb-0">New Password</label>
                                <input type="password" class="form-control" id="newPass" name="newPass" required>
                                <i class="fa-solid fa-eye position-absolute" id="showPass"></i>
                                <i class="fa-solid fa-eye-slash position-absolute" id="hidePass"></i>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="newPassConfirm" class="form-label fw-semibold mb-0">Retype new Password</label>
                                <input type="password" class="form-control" id="newPassConfirm" name="newPassConfirm" required>
                                <i class="fa-solid fa-eye position-absolute" id="showPass"></i>
                                <i class="fa-solid fa-eye-slash position-absolute" id="hidePass"></i>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/js/profile.js"></script>
@endsection