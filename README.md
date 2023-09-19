# TeaTime-Symfony
## Polski
### Opis projektu
**Internetowy katalog herbat, pozwalający na ich przeglądanie i komentowanie przez zalogowanych użytkowników. Herbaty są dodawane przez użytkowników i widoczne publicznie, bez moderacji.**

**[Link do projektu](https://wierzba.wzks.uj.edu.pl/~20_chybowski/tea-time/tea)**

**Przygotowane w ramach zajęć z przedmiotu System Interakcyjny na kierunku Elektroniczne Przetwarzanie Informacji prowadzonego na Uniwersytecie Jagiellońskim.**

### Instrukcja instalacji
Instrukcja dotycząca instalacji na skonfigurowanym serwerze Apache2.
1. Przed umieszczeniem katalogu z projektem na serwerze w pliku .env ustawiamy parametry dostępowe do bazy danych:
   1. nazwa_uzytkownika - nazwa uzytkownika mysql np. 20_chybowski
   2. haslo - haslo uzytkownika mysql
   3. Można również zmodyfikować adres IP serwera jeśli jest potrzeba
2. Katalog `app` umieścić w wybranym miejscu (opcjonalnie można zmienić nazwę np. na tea-time).
3. Nadać odpowiednie uprawnienia folderom vendor, var i public - np wpisując w katalogu komendy `$ chmod 777 var`, `$ chmod 777 vendor` i `$ chmod -R 777 public`.
4. Tworzymy link symboliczny z katalogu `~/public_html` do katalogu `public` wewnątrz aplikacji używając polecenia `ln`.
5. W katalogu projektu instalujemy projekt wpisująć `composer install`.
6. Po zakończeniu instalacji wypełniamy bazę danych poleceniami `$ symfony console doctrine:migrations:migrate` i `$ symfony console doctrine:fixtures:load`.
7. Otwieramy adres nasza_domena.pl/tea-time/tea.

**Aplikacja jest gotowa do działania.**

### Wygląd aplikacji
Strona główna
![Zrzut ekranu 2023-09-19 o 18 49 50](https://github.com/radekchybowski/TeaTime-Symfony/assets/92121154/e07c2cd5-d95b-4c2d-85e4-4347aed30780)

Strona pojedynczej herbaty
![Zrzut ekranu 2023-09-19 o 18 50 11](https://github.com/radekchybowski/TeaTime-Symfony/assets/92121154/86deb44f-83d4-4ee2-8d29-a0800dce416a)

Formularz logowania
![Zrzut ekranu 2023-09-19 o 18 50 39](https://github.com/radekchybowski/TeaTime-Symfony/assets/92121154/ac215bb1-e673-485b-b80b-2dc6f104eeae)

**Podziękowania dla Pana Profesora Tomasza Chojny za dokładne tłumaczenie zagadnień i Marcina Chochorowskiego za pomoc z phpStorm.**

## English
**Wep application for storing and collecting information about different tea varietes. Done for Interactive Systems classes on EPI UJ.** 


