# chgkdb-api

Веб-приложение, реализующее входную точку для всевозможных внутренних и внешних API [Базы вопросов](https://db.chgk.info).

Сложную логику предполагается реализовывать в отдельных компонентах, здесь -- только то, что касается веб-интерфейса.

Сейчас реализована только одна ручка -- http://api.baza-voprosov.ru/questions/validate (swagger-документация на http://api.baza-voprosov.ru/)
и тестовая форма к ней -- http://api.baza-voprosov.ru/validator

Реальный вызов ручки в Базе -- https://github.com/chgk/db.chgk.info/blob/master/www/sites/all/modules/chgk_db/classes/DbUnsorted.class.php#L85

