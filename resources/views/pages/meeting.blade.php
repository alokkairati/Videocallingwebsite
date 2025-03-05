<html>
<head>
    <style>
        #root {
            width: 100vw;
            height: 80vh;
        }
    </style>
    <link rel="icon" type="image/x-icon" href="https://hindtechlearningpoint.com/assets/images/favicon/favicon1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="d-flex justify-content-between">
        <p></p>
        <h2 class="text-center mt-3">{{ Auth()->user()->name }} : <span id="clock"></span></h2>
        <div class="me-5 mt-3">
            @if(is_meeting_owner())
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-paper-plane small"></i> Send Invitation
            </button>
            @endif
        </div>
    </div>
    <hr>
    <div id="root"></div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invite Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="search" class="form-control mb-3" placeholder="Type to Search...">
                    <div style="max-height: 700px; overflow-y: auto;">
                        <table class="table table-sm">
                            <tbody id="userTable">
                                @foreach ($userList as $list)
                                    <tr class="m-2 p-1">
                                        <td>{{ $list->name }}</td>
                                        <td><button class="btn btn-sm btn-primary rounded-pill send-invite @if(is_invited($list->id,$userId)) disabled @endif" data-id="{{ $list->id }}">@if(is_invited($list->id,$userId)) <i class="fa fa-check-circle"> @else Send @endif</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function updateClock() {
        const now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;

        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const dayOfWeek = days[now.getDay()];
        const dayOfMonth = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const formattedTime = `${hours}:${minutes}`;
        const formattedDate = `${dayOfWeek} ${dayOfMonth} - ${month} ${year}`;

        document.getElementById('clock').textContent = `${formattedTime} ${formattedDate}`;
    }

    // Combined window.onload function
    window.onload = function () {
        updateClock(); // Call the clock update function
        function getUrlParams(url) {
            let urlStr = url.split('?')[1];
            const urlSearchParams = new URLSearchParams(urlStr);
            const result = Object.fromEntries(urlSearchParams.entries());
            return result;
        }

        const roomID = ({{ $userId }}) + "";
        const userID = Math.floor(Math.random() * 10000) + "";
        const userName = "{{ Auth()->user()->name }}";
        const appID = 908620037;
        const serverSecret = "442824c53e1667fac226d3be52bb2697";
        const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);

        const sharedLink = {
            name: 'Personal link',
            url: window.location.protocol + '//' + window.location.host + window.location.pathname + '?roomID=' + roomID,
        };

        const zp = ZegoUIKitPrebuilt.create(kitToken);
        zp.joinRoom({
            container: document.querySelector("#root"),
            sharedLinks: [sharedLink],
            scenario: {
                mode: ZegoUIKitPrebuilt.VideoConference,
            },
            turnOnMicrophoneWhenJoining: true,
            turnOnCameraWhenJoining: true,
            showMyCameraToggleButton: true,
            showMyMicrophoneToggleButton: true,
            showAudioVideoSettingsButton: true,
            showScreenSharingButton: true,
            showTextChat: true,
            showUserList: true,
            maxUsers: 50,
            layout: "Grid",
            showLayoutButton: true,
        });
    };
</script>
<script>
    $(document).ready(function () {
        $('.send-invite').click(function () {
            let ths = $(this);
            let id =  ths.data('id');

            $.ajax({
                url: "{{ route('save.invitation') }}",
                type: "POST",
                data: { 
                    _token: '{{ csrf_token() }}',
                    user_id: id
                },
                success: function (response) {
                    ths.html('<i class="fa fa-check-circle"></i>');
                    ths.prop('disabled', true);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors?.id) {
                        alert(errors.id[0]);
                    } else {
                        alert('An unexpected error occurred.');
                    }
                }
            });
        });
    });

    document.getElementById('search').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tr');
        
        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    });

</script>

</html>
