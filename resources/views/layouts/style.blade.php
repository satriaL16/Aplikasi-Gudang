    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
    <style>
        .user-profile-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-profile-toggle .user-image {
            float: none;
            width: 32px;
            height: 32px;
            margin: 0;
            border: 2px solid #e9ecef;
            object-fit: cover;
        }

        .user-profile-toggle-name {
            color: #343a40;
            font-weight: 600;
        }

        .user-profile-dropdown {
            width: 280px;
            min-width: 280px;
            padding: 0;
            overflow: hidden;
            border: 0;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgb(33 37 41 / 18%);
        }

        .navbar-nav > .user-menu > .dropdown-menu.user-profile-dropdown > li.user-profile-header {
            display: flex;
            height: auto;
            min-height: 220px;
            flex-direction: column;
            align-items: center;
            padding: 24px 18px 20px;
            background: linear-gradient(145deg, #343a40 0%, #18212b 100%);
            text-align: center;
        }

        .navbar-nav > .user-menu > .dropdown-menu.user-profile-dropdown > li.user-profile-header > .user-profile-avatar {
            width: 76px;
            height: 76px;
            margin: 0 0 12px;
            border: 3px solid rgb(255 255 255 / 85%);
            box-shadow: 0 3px 12px rgb(0 0 0 / 22%);
            object-fit: cover;
        }

        .user-profile-info {
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            color: #fff;
        }

        .user-profile-name {
            max-width: 100%;
            overflow-wrap: anywhere;
            font-size: 16px;
            line-height: 1.3;
        }

        .user-profile-email {
            max-width: 100%;
            color: rgb(255 255 255 / 72%);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .user-profile-role {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            max-width: 100%;
            margin-top: 5px;
            padding: 5px 10px;
            border: 1px solid rgb(255 255 255 / 24%);
            border-radius: 999px;
            background: rgb(255 255 255 / 12%);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.4;
            white-space: nowrap;
        }

        .user-menu .dropdown-menu.user-profile-dropdown > .user-footer {
            padding: 12px;
            background: #fff;
        }

        .user-profile-logout {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 12px;
            border: 1px solid #f1d0d3;
            border-radius: 6px;
            background: #fff5f5;
            color: #c82333;
            font-size: 13px;
            font-weight: 600;
            transition: background-color 150ms ease, color 150ms ease;
        }

        .user-profile-logout:hover,
        .user-profile-logout:focus {
            background: #dc3545;
            color: #fff;
        }

        @media (max-width: 575.98px) {
            .user-profile-dropdown {
                width: min(280px, calc(100vw - 16px));
                min-width: min(280px, calc(100vw - 16px));
            }
        }
    </style>
