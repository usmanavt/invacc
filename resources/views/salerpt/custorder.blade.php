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
    border-bottom: 2px double gray;
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
}
.data tr td{
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
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
                <td align="left" style="width:20%;">
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                </td>
                <td align="center" style="width:60%;">
                    {{-- <h1>MUHAMMAD NAZIR & Co. </h1> --}}
                    <h1> {{ $hdng1 }} </h1>
                </td>
                <td align="right" style="width:20%;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </td>
.            </tr>
        </tbody>
    </table>

    {{-- Address --}}
    <table>
        <tbody>
            <tr>





                <td  style="text-align: center;">
                    {{ $hdng2 }}
                    {{-- <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes & Tubes</h3> --}}
                    {{-- <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3> --}}
                    {{-- <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:3rem;font-weight: bold">Customer Order</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Customer Name
                </td>
                <td>
                    {{ $data[0]->custname }}
                </td>
                <td>
                    P.O No
                </td>
                <td>
                    {{ $data[0]->pono }}
                </td>
                <td>
                    P.O Date
                </td>
                <td>
                     {{ $data[0]->podate }}
                </td>
            </tr>
            <tr>
                <td>
                    P.R No
                </td>
                <td>
                    {{-- From {{ $fromdate }} to {{ $todate }} --}}
                    {{ $data[0]->prno }}
                </td>

                <td>
                    Delivery Date
                </td>
                <td>
                    {{ $data[0]->deliverydt }}
                </td>


            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="" width="4%">S#</th>
                    {{-- <th class="" width="16%">Group Name</th> --}}
                    <th class="" width="40%">Material Name</th>
                    <th class="" width="7%">Unit</th>
                    <th class="" width="20%">Brand</th>
                    <th class="" width="9%">Quantity</th>
                    <th class="" width="9%">Price</th>
                    <th class="" width="11%">Amount</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $vvlues = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)

            <tr>


                {{ $vvlues += $data[$i]->saleamnt }}


                <td class="" width="4%">{{ $i+1 }}</td>
                {{-- <td class="" width="16%">{{ $data[$i]->grpname }} </td> --}}
                <td class="" width="40%">{{ $data[$i]->matname }} </td>
                <td style="text-align:center" width="7%">{{ $data[$i]->UOM }} </td>
                <td style="text-align:left" width="20%">{{ $data[$i]->mybrand }} </td>
                <td class="" width="9%">{{ number_format($data[$i]->qty,1) }} </td>
                <td class="" width="9%">{{ number_format($data[$i]->price,1) }} </td>
                <td style="text-align:right" width="11%">{{ number_format($data[$i]->saleamnt,0) }} </td>

            </tr>
            @endfor
            <tr>
                <td colspan="8" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
                {{-- <td colspan="4" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vtotpcs,0) }} </td> --}}
                {{-- <td class="1" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td> --}}
                {{-- <td class="2" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td> --}}
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
