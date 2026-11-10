# Scheduler a Mutex

Návrh plánovače úloh nezávislého na konkrétní knihovně. Aktuální implementace: Laravel Scheduler, mutex přes `flock`.

## Struktura

- `src/Scheduling` – jádro plánování, bez Laravelu
- `src/Mutex` – vlastní mutex, bez Laravelu
- `src/Scheduling/Laravel` – jediné místo s Laravelem (adaptér, dva příkazy, service provider)
- `src/Products`, `src/Invoices` – ukázkové handlery (business logika, není součástí zadání)
