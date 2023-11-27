<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
* {
    margin:0;
    padding:0;
    font-size:0.8rem;
    font-style: normal;
    box-sizing: border-box;
}
table{
    width:100%;
}
.ledger {
    border:1px solid lightgray;
    padding:12px;
}
.column-headers{
    border:1px solid lightgray;
    background: #e3e3e3;
    margin-top:5px;
    margin-bottom:5px;
    border-bottom: 2px double  lightgray;
    border-collapse: collapse;
    text-align: center;
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
}
.data tr td{
    border-left: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 0.8rem;
    font-style: normal;
}
.data tr td:nth-child(7){
    border-right:1px solid lightgray;
}
.data tr td:nth-child(5),
.data tr td:nth-child(6),
.data tr td:nth-child(7),{
    text-align: right;
}
.data tr:last-child{
    border-bottom:solid thin;
}
</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}
    <table>
        <tbody>
            <tr>
                {{-- logo --}}
                {{-- <td align="left" style="width:20%;"> --}}
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                {{-- </td> --}}
                <td style= "text-align:center; width:60%;">
                    <h1>MUHAMMAD NAZIR & Co </h1>
                </td>
                {{-- <td align="right" style="width:20%;"> --}}
                    {{-- &nbsp;&nbsp;&nbsp;&nbsp; --}}
                {{-- </td> --}}
            </tr>
        </tbody>
    </table>

    {{-- Address --}}
    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.8rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.8rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.8rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1.5rem">CUSTOMER AGEING DETAIL </span>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                <td>
                    Head Type
                </td>
                <td>
                    {{ $data[0]->mheadname }}
                </td>
            </tr>

            <tr>
                <td>
                    Customer Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td>
                <td>
                    Phone No
                </td>
                <td>
                    {{ $data[0]->phoneoff }}
                </td>
            </tr>






        </tbody>
    </table>

    {{-- column headers --}}
    <table class="column-headers">
        <thead>
            <tr>
                <th class="column-headers" width="5%">S#</th>
                <th class="column-headers" width="15%">Ref.</th>
                <th class="column-headers" width="15%">Delivery<br>Date</th>
                <th class="column-headers" width="15%">Delivery<br>No</th>
                <th class="column-headers" width="20%">Invoice<br>Balance</th>
                <th class="column-headers" width="15%">Ageing<br>Days</th>
                <th class="column-headers" width="15%">Ageing<br>Months</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $vinvbal = 0 }}
            {{-- {{ $vdb = 0 }} --}}
            {{-- {{ $vcd = 0 }} --}}
            {{-- {{ $vcb = 0 }} --}}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>
                {{-- {{ $vob += $data[$i]->OB }} --}}
                {{-- {{ $vdb += $data[$i]->DEBIT }} --}}
                {{-- {{ $vcd += $data[$i]->CREDIT }} --}}
                {{ $vinvbal += $data[$i]->invoicebal }}

                <td style="text-align:center"; width="5%">{{ $i+1 }}</td>
                <td style="text-align: center"; width="15%">{{ $data[$i]->ref }} </td>
                <td style="text-align: center"; width="15%">{{ $data[$i]->invoice_date }} </td>
                <td style="text-align: center"; width="15%">{{ $data[$i]->invoiceno }} </td>
                <td style="text-align: right"; width="20%">{{ number_format($data[$i]->invoicebal,0) }} </td>
                <td style="text-align: right"; width="15%">{{ number_format($data[$i]->days,0) }} </td>
                <td style="text-align: right"; width="15%">{{ number_format($data[$i]->mnth,0) }} </td>

            </tr>
            @endfor

            <tr>
                {{-- <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold"> Total </td> --}}
                <td colspan="5" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vinvbal,0) }} </td>
                <td colspan="2" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold"> </td>
                {{-- <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vcd,0) }} </td> --}}
                {{-- <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vcb,2) }} </td> --}}
            </tr>





        </tbody>
    </table>

    {{-- Footer  --}}
    <div style="margin-top:64px;">
        <table >

            <tr style="margin-top:16px;margin-bottom:16px;">
                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>
            </tr>
            <tr>
                <td style="width=33%;font-size:80%;text-align:center">
                    Prepared By
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    Approved By
                </td>
            </tr>
        </table>
    </div>

    </body>
</html>
