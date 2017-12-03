import os
import csv
import xlrd


def open_csv(to_read):
    """
    Open a text file for reading, then iterate over it with a csv reader,
    returning a list of lists, each containing 1 row.
    """
    def unicode_csv_reader(unicode_csv_data, dialect = csv.excel, **kwargs):
        """ Encode utf-8 strings from CSV as Unicode """
        csv_reader = csv.reader(unicode_csv_data,
                                dialect = dialect, **kwargs)
        for row in csv_reader:
            # decode UTF-8 back to Unicode, cell by cell:
            yield [unicode(cell.strip(), 'utf-8') for cell in row if cell]
    try:
        with open(to_read, 'rU') as got_a_file:
            return [line for line in unicode_csv_reader(got_a_file)]
    except (IOError, csv.Error):
        print ("Couldn't read from file %s. Exiting." % (to_read))
        raise

def open_excel(to_read):
    """
    Open an Excel workbook and read rows from first sheet into sublists
    """
    workbook = xlrd.open_workbook(to_read)
    sheet = workbook.sheet_by_index(0)
    plu = []
    for row in range(sheet.nrows):
        plu.append([sheet.cell(row, col).value for col in range(sheet.ncols)])
    return plu

def save_as_xls(lines_to_write, output_filename):
    """
    Write a list of lists to an Excel (xls) sheet, one row per nested list
    """
    # initialise a new Excel workbook object, and a worksheet
    from xlwt import Workbook
    from xlwt import XFStyle
    book = Workbook(encoding = 'utf-8')
    sheet = book.add_sheet('Sheet 1')
    style = XFStyle()
    style.num_format_str = 'general'
    # iterate through the nested lists
    for row_index, row_contents in enumerate(lines_to_write):
        for column_index, cell_value in enumerate(row_contents):
            sheet.write(row_index, column_index, cell_value, style)
    # write the file to the current working directory
    book.save(os.path.join(os.getcwd(), output_filename))
