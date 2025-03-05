<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

        <title>Meeting Link</title>
    </head>

    <body>
        <div class="container">

            <section class="">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('panel.dashboard') }}">
                            <img src="nex.png"
                                alt="" style="width: 200px">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <h3 class="text-primary mb-0 mt-2">{{ auth()->user()->name }}</h3>
                                    <p class="text-muted">{{ auth()->user()->email }}</p>
                                </li>
                            </ul>

                            <ul class="navbar-nav">
                                <li class="nav-item me-4">
                                    <a class="nav-link fw-bold" href="#" title="Current Date &amp; Time"><small
                                            class="fs-6" id="clock"></small></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" href="{{ route('previous.meeting') }}"
                                        title="Meeting List"><i class="fa fa-list" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </section>

            
            <section class="meetings-list p-5">
                <div class="card p-3">
                    <div class="card-content">
                        <div class="card-title fe-bold h5">Meeting List</div>
                        <div class="table-responsive m-5">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Meeting Link</th>
                                        <th>Room ID</th>
                                        <th>User ID</th>
                                        <th>Members</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($meetings as $meeting)
                                    <tr>
                                        <td>{{ $meeting->meeting_link }}</td>
                                        <td>{{ $meeting->room_id }}</td>
                                        <td>{{ $meeting->meeting_user }}</td>
                                        <td>{{ $meeting->invited_users_counts ?? 0 }}</td>
                                        <td>{{ date('d M,Y',strtotime($meeting->created_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>




        </div>


        <button class="btn btn-danger position-fixed bottom-0 end-0 m-3 rounded-pill shadow">
            <a href="{{ route('logout') }}" class="nav-link text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </button>

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

            setInterval(updateClock, 1000);

            window.onload = updateClock;
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    </body>

</html>
