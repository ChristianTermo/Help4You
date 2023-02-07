<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="main">
        <div class="content">
            <div class="controls">
                <div class="icon">
                    <img src="/imagines/siconsLogo.png" alt="logos">
                </div>
                <form action=" {{ route('login.custom') }} " method="POST">
                    @csrf
                    <div class="inputs">
                        <svg class="login" xmlns="http://www.w3.org/2000/svg" width="44" height="40" viewBox="0 0 44 40">
                            <g stroke="#fff" fill="none" stroke-width="3.538" transform="translate(0 -1012.362)">
                                <ellipse ry="8.09" rx="8.244" cy="1022.221" cx="21.555" stroke-linecap="round" />
                                <path d="M1.858 1046.4c-.79 4.74 3.805 4.11 3.805 4.11H37.88s4.846.936 4.312-3.854c-.533-4.79-6.076-10.937-20.04-11.043-13.964-.106-19.504 6.047-20.294 10.786z" />
                            </g>
                        </svg>
                        <input class="input" type="email" placeholder="user@sincos.it" id="" name="" required>
                        
                        <svg class="lock" xmlns="http://www.w3.org/2000/svg" width="44" height="46" viewBox="0 0 44 46">
                            <g transform="translate(-28.15 -974.678)" stroke="#fff" fill="none" stroke-width="3.509">
                                <rect ry="3.136" y="995.18" x="29.903" height="23.743" width="40.491" stroke-linecap="round" />
                                <path d="M49.386 1004.406v4.788" stroke-linecap="round" />
                                <path d="M37.073 994.83s-1.39-18.398 12.97-18.398c14.36 0 12.207 18.397 12.207 18.397" />
                            </g>
                        </svg>
                        <input class="input" type="password" name="password" placeholder="password" id="password" required>
                        
                        <button class="button">
                            <div class="circle animate"></div><span class="sign-in">Sign in</span>
                            <div class="loader"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>