# Scarlet 

![GitHub Workflow Status](https://img.shields.io/github/workflow/status/sifex/scarlet-api/Laravel)



This is the Laravel API for Scarlet – Built by AAF.


## Getting Started

```bash
# Install
composer install

# Run
sail up -d
sail npm i
```

## Testing

```bash
# Feature Tests
sail test
```

## Development

```mermaid
sequenceDiagram
    participant U as User
    participant E as Electron App
    participant B as Browser
    participant L as Laravel Backend
    participant S as Steam

    %% Standard Flow
    U->>B: Access "/"
    B->>L: Request "/"
    L-->>B: Return home page
    U->>B: Click login
    B->>L: GET "/login/steam"
    L-->>B: Redirect to Steam
    B->>S: Redirect to Steam login
    U->>S: Enter credentials
    S-->>B: Redirect to "/auth/steam"
    B->>L: GET "/auth/steam"
    L-->>B: Set session, redirect to app
    B-->>U: Show app features

    %% Electron Flow
    U->>E: Click Electron login
    E->>B: Open "/browser/steam/verify"
    B->>L: GET "/browser/steam/verify"
    L-->>B: Generate token, redirect to "/login/steam"
    B->>L: GET "/login/steam"
    L-->>B: Redirect to Steam
    B->>S: Redirect to Steam login
    U->>S: Enter credentials
    S-->>B: Redirect to "/auth/steam"
    B->>L: GET "/auth/steam"
    L-->>B: Set session, redirect to "/browser/steam/verify"
    B->>L: GET "/browser/steam/verify" with token
    L-->>B: Redirect to Electron app (deep link)
    B-->>E: Deep link to app
    E->>L: GET "/electron/steam/verify"
    L-->>E: Confirm login, return app data
    E-->>U: Show Electron app interface

```

Then open http://localhost
