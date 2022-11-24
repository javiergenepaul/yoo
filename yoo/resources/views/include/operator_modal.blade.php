{{-- LOGOUT --}}
<div class="modal fade" id="logout" data-bs-backdrop="modal" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- Logout URl here --}}
                <a href="{{ route('operator.logout') }}"><button type="button"
                        class="btn btn-primary">Logout</button></a>
            </div>
        </div>
    </div>
</div>

{{-- CONFIRM OTP Email --}}
{{-- <div class="modal fade" id="confirm-email-otp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verify with Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-lowercase">We just send a code to:
                            <strong>drivers@gmail.com</strong></label>
                        <input type="text" class="form-control" id="recipient-name" placeholder="Enter Code">
                    </div>
                    <button type="button" class="btn btn-primary" id="send-code-email" data-bs-toggle="modal">Send
                        Code</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>

</div> --}}

{{-- CONFIRM OTP Mobile --}}
{{-- <div class="modal fade" id="confirm-mobile-otp" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verify with Mobile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label text-lowercase">We just send a code to:
                            <strong>drivers@gmail.com</strong></label>
                        <input type="text" class="form-control" id="recipient-name" placeholder="Enter Code">
                    </div>
                    <button type="button" class="btn btn-primary" id="send-code-mobile" data-bs-toggle="modal">Send
                        Code</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div> --}}

{{-- CHANGE PASSWORD --}}
{{-- <div class="modal fade" id="change-password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change New Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">New Password:</label>
                        <input type="password" class="form-control" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Confirm New Password:</label>
                        <input type="password" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm-email-otp"
                    data-bs-dismiss="modal">Verify with Email</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#confirm-mobile-otp" data-bs-dismiss="modal">Verify with Mobile</button>

            </div>
        </div>
    </div>
</div> --}}

{{-- EDIT PROFILE --}}
{{-- <div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-md-6">
                        <label for="recipient-name" class="col-form-label">Mobile:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="col-form-label">Mobile OTP:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="col-form-label">Email OTP:</label>
                        <input type="email" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-md-12">
                        <label for="recipient-name" class="col-form-label">Date of Birth:</label>
                        <input type="date" class="form-control" id="recipient-name">
                    </div>

                    <div class="col-md-12">
                        <label for="recipient-name" class="col-form-label">Address:</label>
                        <input type="address" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="col-form-label">Country:</label>
                        <select class="form-select" id="autoSizingSelect">
                            <option selected>Choose...</option>
                            <option value="1">Philippines</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="recipient-name" class="col-form-label">Province:</label>
                        <select class="form-select" id="autoSizingSelect">
                            <option selected>Choose...</option>
                            <option value="1">Cebu</option>
                            <option value="1">Manila</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="recipient-name" class="col-form-label">City/Municipality:</label>
                        <input type="city" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-md-5">
                        <label for="recipient-name" class="col-form-label">Barangay:</label>
                        <input type="barrio" class="form-control" id="recipient-name">
                    </div>

                    <div class="col-md-2">
                        <label for="recipient-name" class="col-form-label">Postal Code:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div> --}}
