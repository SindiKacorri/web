
## Requirements

Si fillim duhet qe ambjenti ku runohet projekti te kete :
- [Composer](https://getcomposer.org/download/)
- PHP >= 5.6
- Node.Js > 7.5 [Link](https://nodejs.org/en/download/)


## Instalimi

Pasi downloadohet projekti, futemi tek folderi kryesor i projektit dhe shkruajme `composer install`.
Kjo komande vonon pak sepse downloadohet framework Laravel. Pasi te kete mbaruar kjo komande, shkruajme `npm install`

Pas kesaj duhet qe file `.env.example` ti ndryshojme emrin ne `.env`. E hapim file dhe plotesojme fushat si me poshte:

- `DB_DATABASE=schoolweb`
- `DB_USERNAME=root`
- `DB_PASSWORD=root`

Fusha `DB_DATABASE` permban emrin e databazes qe keni ne kompjuter.
Fusha `DB_USERNAME` permban emrin e userit qe perdor aplikacioni per tu lidhur me databazen.
Fusha `DB_PASSWORD` permban passwordin e userit qe perdor aplikacioni per tu lidhur me databazen.

Pasi i kemi plotesur te gjitha fushat e ruajme kete file. Hapim command line ne folderin root te projektit dhe shkruajme komanden `php artisan key:generate`. Kjo komande do te shfaqe output ne command line nje celes qe do perdoret per enkriptim.

## Krijimi i tabelave

Per te krijuar strukturen e databazes duhet qe te futemi me command line tek folderi root i projektit dhe te shkruajme :
`php artisan migrate`. Nese ndodh nje problem duhet te rishikosh vlerat tek file `.env`

## Kompilimi i asseteve

Per te krijuar version te kompiluar te asseteve, nga folderi root i projektit, ne command line shkruajme :
- `npm run dev` per te krijuar version te pa minifikuar
- `npm run prod` per te krijuar version te minifikuar
