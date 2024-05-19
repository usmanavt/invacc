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
    width:100%;.
}
.ledger {
    border:1px solid lightgray;
    padding:12px;
}
.column-headers{
    border:1px solid lightgray;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    background: #e3e3e3;
    font-size: 0.9rem;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;
    /* border-bottom: 2px double gray; */
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
    font-size: 1rem;
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
                    <h1>{{ $hdng1 }} </h1>
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
                    {{-- <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                    <h3> {{ $hdng2 }}  </h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">DUTY PAYABLE SUMMARY </span>
                </td>
            </tr>

        {{-- <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $ltype }}</span>
            </td>

        </tr> --}}


        </tbody>
    </table>

    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                {{-- <td>
                    Supplier Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td> --}}

                {{-- <td>
                    Invoice No
                </td>
                <td>
                    {{ $data[0]->purinvsno }}
                </td> --}}

                {{-- <td>
                    Contract Id
                </td>
                <td>
                    {{ $data[0]->contract_id }}
                </td> --}}

            </tr>
            <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                {{-- <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>

                <td>
                    Contract Date
                </td>
                <td>
                    {{ $data[0]->contract_date }}
                </td>
 --}}

            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="3"  style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;">Invoice</td>
                <td colspan="2"  style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">GD</td>
                <td colspan="2"  style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Conversion</td>
                <td colspan="3"  style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Duty Payable</td>
                <td colspan="3"  style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Duty Payed</td>
                <td colspan="3"  style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Balance</td>
            </tr>

            <tr>
                    <th class="column-headers" width="2%">S#</th>
                    <th class="column-headers" width="8%">Date</th>
                    <th class="column-headers" width="8%">No</th>
                    <th class="column-headers" width="8%">Date</th>
                    <th class="column-headers" width="8%">No</th>
                    <th class="column-headers" width="6%">Rate</th>
                    <th class="column-headers" width="6%">Insur.</th>
                    <th class="column-headers" width="6%">Bundle</th>
                    <th class="column-headers" width="6%">Weight</th>
                    <th class="column-headers" width="6%">Duty</th>
                    <th class="column-headers" width="6%">Bundle</th>
                    <th class="column-headers" width="6%">Weight</th>
                    <th class="column-headers" width="6%">Duty</th>
                    <th class="column-headers" width="6%">Bundle</th>
                    <th class="column-headers" width="6%">Weight</th>
                    <th class="column-headers" width="6%">Duty</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

           {{ $vbundlpbl = 0 }};{{ $vwtpbl = 0 }};{{ $vdutypbl = 0 }};
           {{ $vbundlpayed = 0 }};{{ $vwtpayed = 0 }};{{ $vdutypayed = 0 }};
           {{ $vbundlbal = 0 }};{{ $vwtbal = 0 }};{{ $vdutybal = 0 }};


            @for ($i = 0 ; $i < count($data) ; $i++)

            {{ $vbundlpbl += $data[$i]->packingwt }};{{ $vwtpbl += $data[$i]->twt }};{{ $vdutypbl += $data[$i]->duty }};
            {{ $vbundlpayed += $data[$i]->clrbundle }};{{ $vwtpayed += $data[$i]->clrwt }};{{ $vdutypayed += $data[$i]->clrdty }};
            {{ $vbundlbal += $data[$i]->balbundle }};{{ $vwtbal += $data[$i]->wtbal }};{{ $vdutybal += $data[$i]->balduty }};

            <tr>

                <td style="text-align:center" width="2%">{{ $i+1 }}</td>
                <td style="text-align:center" width="8%">{{ $data[$i]->invoice_date}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->invoiceno}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->machine_date}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->machineno}} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->conversionrate,2) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->insurance,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->packingwt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->twt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->duty,0) }} </td>

                <td style="text-align:right" width="6%">{{ number_format($data[$i]->clrbundle,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->clrwt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->clrdty,0) }} </td>

                <td style="text-align:right" width="6%">{{ number_format($data[$i]->balbundle,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->wtbal,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->balduty,0) }} </td>

            </tr>
            @endfor


            {{-- {{ $vbundlpbl = 0 }};{{ $vwtpbl = 0 }};{{ $vdutypbl = 0 }};
            {{ $vbundlpyed = 0 }};{{ $vwtpyed = 0 }};{{ $vdutypyed = 0 }};
            {{ $vbundlbal = 0 }};{{ $vwtbal = 0 }};{{ $vdutybal = 0 }}; --}}




            <tr>
                <td colspan="7"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold"> Total </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vbundlpbl,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vwtpbl,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vdutypbl,0) }} </td>

                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vbundlpayed,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vwtpayed,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vdutypayed,0) }} </td>


                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vbundlbal,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vwtbal,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vdutybal,0) }} </td>


            </tr>






        </tbody>
    </table>

    {{-- Footer  --}}
    <div style="margin-top:64px;">
        <table >

            {{-- <tr style="margin-top:16px;margin-bottom:16px;">
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
            </tr> --}}






        </table>






    </div>



    </body>

</html>
