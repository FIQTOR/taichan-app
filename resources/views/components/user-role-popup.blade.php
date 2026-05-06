<div id="user-role-popup" class="hidden fixed w-full h-screen left-0 top-0 bg-black bg-opacity-50 z-50 items-center">
    <div class="relative mx-auto w-full max-w-sm bg-white h-fit rounded-xl shadow-xl">
        <button
            onclick="
          $('#user-role-popup').addClass('hidden');
          $('#user-role-popup').removeClass('flex');"
            class="absolute right-0 bg-red-500 rounded-bl-lg rounded-tr-lg p-1 hover:bg-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
            </svg>
        </button>
        <form id="user-role-popup-form" action="#" class="h-full flex flex-col justify-between">
            @csrf
            @method('PUT')
            <input id="name-role-popup-nameid" type="text" name="name" hidden readonly>
            <div class="p-1">
                <img id="user-role-popup-img" src="" alt="" class="rounded-full">
                <div class="p-4">
                    <div class="flex justify-between">
                        <span>Name</span>
                        <span id="user-role-popup-name">Example Name</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Email</span>
                        <span id="user-role-popup-email">example@gmail.com</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Role</span>
                        <span id="user-role-popup-role">user</span>
                    </div>
                    <div class="flex justify-between">
                        <label for="role">Ganti ke role</label>
                        <select name="role" id="role" class="px-2 py-1 border rounded-md">
                            <option value="user">User</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-full px-14 p-4">
                <button onclick="setRoleAjax(event)"
                    class="w-full bg-yellow-400 rounded-full py-1 hover:opacity-70">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleRolePopup(picture, name, email, role) {

        $('#name-role-popup-nameid').val(name);

        $('#user-role-img').attr('src', `{{ asset('storage') }}/` + picture);

        $('#user-role-popup-name').html(name);
        $('#user-role-popup-email').html(email);
        $('#user-role-popup-role').html(role);

        $('#user-role-popup').addClass('flex');
        $('#user-role-popup').removeClass('hidden');
    }

    function handleRate(value, event) {
        event.preventDefault();
        $('#rating').val(value);

        for (let i = 0; i < 5; i++) {
            $('#star' + (i + 1)).removeClass('text-neutral-200');
            $('#star' + (i + 1)).removeClass('text-yellow-300');
            if (i < value) {
                $('#star' + (i + 1)).addClass('text-yellow-300');
            } else {
                $('#star' + (i + 1)).addClass('text-neutral-200');
            }
        }
    }

    function setRoleAjax(e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('user-role-popup-form'));

        $.ajax({
            type: 'post',
            url: `{{ route('user.role.update') }}`,
            data: formData,
            contentType: false, // To send as FormData
            processData: false, // To prevent jQuery from processing the data

            success: function(res) {
                $('#user-role-popup').addClass('hidden');
                $('#user-role-popup').removeClass('flex');

                $('#role-' + res.name.toLowerCase().replace(/ /g, '-')).html(res.role);
            }
        });
    }
</script>
