Sub FacStaffStudent()
    'select the Fac, Staff, Student sheet
    Dim sheetname As String
    sheetname = "Fac, Staff, Student"
    Sheets(sheetname).Activate
    Call NameFacStaffStudentCells
End Sub

Sub NameFacStaffStudentCells()
'set values for the cells in the Fac, Staff, Student worksheet
    Dim breakdown As String, month As String, year As String
    month = MonthName(Format(Now, "m"))
    year = Format(Now, " yyyy")
    breakdown = "Breakdown - " + month + year
    ActiveSheet.Range("A1").Value = "Faculty, Staff, Students"
    ActiveSheet.Range("A2").Value = breakdown
    ActiveSheet.Range("A3").Value = "Faculty"
    ActiveSheet.Range("A4").Value = "Staff"
    ActiveSheet.Range("A5").Value = "Student"
    ActiveSheet.Range("A6").Value = "Total"
    Range("A1", "B1").Merge
    Range("A2", "B2").Merge
    
    With Range("A1:B2")
        .Interior.Color = RGB(122, 73, 96)
    End With
    
    Dim rng As Range
    Set rng = Range("A1:B6")
    rng.BorderAround LineStyle:=xlContinuous
    
    Range("A6").HorizontalAlignment = xlHAlignRight
End Sub

Sub CountFacStaffStudent()
    Dim Worksheet As String
    Worksheet = "Fac, Staff, Student"
    Dim rng As Range
    Set rng = Sheets(1).Rows(1).Find("Job Title")
    'Faculty B3
    Sheets(Worksheet).Range("B3") = StatCountIfFunction(rng.EntireColumn, Range("A3").Value, Worksheet)
    'Staff B4
    Sheets(Worksheet).Range("B4") = StatCountIfFunction(rng.EntireColumn, Range("A4").Value, Worksheet)
    'Student B5
    Sheets(Worksheet).Range("B5") = StatCountIfFunction(rng.EntireColumn, Range("A5").Value, Worksheet)
    'Total B6
    Sheets(Worksheet).Range("B6") = Application.WorksheetFunction.Sum(Sheets(Worksheet).Range("B3:B5"))
End Sub

Function StatCountIfFunction(datarng As Range, condition As String, sheetname As String)
    StatCountIfFunction = Application.WorksheetFunction.CountIf(datarng.EntireColumn, condition)
End Function

Sub DeleteStats()
    Dim rng As Range
    'Find the column in row 1 which called "Event Date"
    Set rng = Sheets(1).Rows(1).Find("Event Date")
    'Count the number of non-empty columns in the entire column
    my_count = Application.WorksheetFunction.CountA(rng.EntireColumn)
    'starting form the last row loop backwards
    'this is because will skip the next row when deleting if loop is not reversed
    For counter = my_count To 2 Step -1
        'get the date in the event_date column relative to the row number
        event_date = rng.Rows(counter)
        'delete the events that are not in the previous month or current year
        'so you don't get extra data
        If ((month(event_date) <> month(Now) - 1) Or (year(event_date) <> year(Now))) Then
        ' need to handle the case when it is January of next year and want to get stats of December the previous year
            Sheets(1).Rows(counter).Delete
        End If
    Next counter
End Sub

Sub CreateFacDeptPivotTable()
    'Pivot Table variables
    Dim wks_source As Worksheet
    Dim wks_dest As Worksheet
    Dim rng_source As Range
    Dim rng_dest As Range
    Dim last_row As Long
    Dim last_col As Long
    
    'Set the worksheets
    Set wks_source = Sheets(1)
    Set wks_dest = Sheets("Fac, Dept")
    
    'Set the data ranges
    With wks_source
        last_row = .Range("A1").End(xlDown).Row
        last_col = .Range("A1").End(xlToRight).Column
        Set rng_source = .Range("A1", .Cells(last_row, last_col))
    End With
    
    'Set destination range
    Set rng_dest = wks_dest.Range("A3")
    
    'Check if Pivot Table already exists
    If (wks_dest.PivotTables.Count <= 0) Then
        'Create the Pivot Table
        wks_source.PivotTableWizard _
            SourceType:=xlDatabase, _
            SourceData:=rng_source, _
            TableDestination:=rng_dest, _
            TableName:="Faculty, Department"
        
        'Fill out the Pivot Table
        With wks_dest.PivotTables("Faculty, Department")
            .PivotFields("Faculty").Orientation = xlRowField
            .PivotFields("Department").Orientation = xlRowField
            .PivotFields("Attendance").Orientation = xlDataField
        End With
    
        'Filter the fields in the Pivot Table
        With wks_dest.PivotTables("Faculty, Department")
            .PivotFields("Attendance").PivotItems("Y").Visible = True
            .PivotFields("Attendance").PivotItems("N").Visible = False
        End With
    Else:
        MsgBox ("Pivot Table already exists!")
    End If
    
End Sub

Sub CreateStatsWorksheets()

    'Set the month and year
    Dim month_name As String, year_num As Integer
    Dim month_stat_sheet As String
    month_name = MonthName(month(Now) - 1)
    year_num = year(Now)
    
    If (month(Now) = 1) Then
    'This will handle the case of January trying to get the stats for December of the previous year
        year_num = year_num - 1
    End If
    
    month_stat_sheet = month_name & " " & year_num & " Stats"
    Sheets.Add.name = month_stat_sheet
    Sheets.Add.name = "Fac, Dept"
    Sheets.Add.name = "Fac, Staff, Student"
End Sub
