# php_Catalog 
В базе данных нужно создать таблицу/таблицы для хранения категорий товаров.
Категории товара имеют древовидную структуру с неограниченной вложенностью:

- Категория 1
- Подкатегория 1-1
- Подкатегория 1-2
- Подподкатегория 1-2-1
- Подподкатегория 1-2-2
- Подкатегория 1-3
- Категория 2
...
- Категория N

Необходимо заполнить таблицу добавив 5000 записей с категориями разного уровня
вложенности.
На главной странице проекта необходимо вывести список категорий в виде
древовидной структуры.
Название категории в дереве должно быть ссылкой, при клике на которую происходит
переход на страницу где выводится путь данной категории следующего вида:

Категория 1 > Подкатегория 1-2 > Подподкатегория 1-2-2
