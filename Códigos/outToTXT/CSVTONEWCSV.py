import xlrd
book = xlrd.open_workbook("pifl3651.xls")
print "Número de abas: ", book.nsheets
sh = book.sheet_by_index(0)
print(sh.name, sh.nrows, sh.ncols)
print("Valor da célula DU é ", sh.cell_value(rowx=29, colx=3))
for rx in range(sh.nrows):
    print(sh.row(rx))

\\teste 