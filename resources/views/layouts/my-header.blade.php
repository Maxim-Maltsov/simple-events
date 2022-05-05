
<header>

    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="{{ route('home') }}">Simple-Events</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('event-form') }}">{{  __('Создать мероприятие') }}<span class="sr-only">(current)</span></a>
                </li>
                @if ( Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('voting-form') }}">{{  __('Запустить голосование') }}</a>
                    </li>
                @endif
            </ul>

            <ul>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-secondary" href="#" id="dropdown01" data-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Выйти') }}</a>
                    </form>

                </div>
                </li>
            </ul>
        </div>
    </nav>

</header>