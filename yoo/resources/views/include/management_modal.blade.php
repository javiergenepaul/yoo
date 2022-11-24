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
                @if (auth()->user()->management->management_role_id == 1)
                    <a href="{{ route('management.logout') }}"><button type="button"
                        class="btn btn-primary">Logout</button></a>
                @else
                    <a href="{{ route('shopadmin.logout') }}"><button type="button"
                        class="btn btn-primary">Logout</button></a>
                @endif
            </div>
        </div>
    </div>
</div>
