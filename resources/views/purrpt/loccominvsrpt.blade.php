.<!DOCTYPE html>
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
    padding:2px;
    margin-top:5px;
    margin-bottom:5px;

}
.column-headers{
    border:1px solid lightgray;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    background: #e3e3e3;
    font-size: 1rem;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;
}

.column-headers1{
    border:1px solid lightgray;
    font-size: 2rem;
    text-align: center;
    font-weight: bold;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;
}

.column-headers1 tr{
    border:1px solid lightgray;
    font-size: 2rem;
    text-align: center;
    font-weight: bold;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;
}

.column-headers2{
    border:1px solid lightgray;
    font-size: 1rem;
    text-align: center;
    /* border-top: 2px;
    border-bottom: 2px;
    border-left: 2px;
    border-right: 2px; */

    margin-top:10px;
    margin-bottom:10px;
    border-collapse: collapse;
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
    /* border-top: 1px solid lightgray; */
    text-align: left;
    font-size: 0.9rem;
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


.data1 {
    border-collapse: collapse;
    font-size: 1rem;
}
.data1 tr td{
    border-left: 1px solid lightgray;
    /* border-top: 1px solid lightgray; */
    text-align: left;
    font-size: 0.9rem;
    font-style: normal;
}
.data1 tr td:nth-child(7){
    border-right:1px solid lightgray;
}
.data1 tr td:nth-child(5),
.data1 tr td:nth-child(6),
.data1 tr td:nth-child(7),{
    text-align: right;

}
.data1 tr:last-child{
    border-bottom:solid thin;
}



</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}

    <table class="column-headers1">
        <tbody>
            <tr  >
                <td >PURCHASE INVOICE  </td>
            </tr>
            <tr  >
                <td style="font-size: 0.8rem" > MUHAMMAD NAZIR & Co </td>
            </tr>
        </tbody>
    </table>


    <table class="column-headers2">
        <tbody>
            <tr  > <td >Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes  </td>  </tr>
            <tr  > <td >Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,  </td>  </tr>
            <tr  > <td >Phone : 021-32588781, 021-32574285 , Fax : 021-32588782  </td>  </tr>

        </tbody>
    </table>








    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                {{-- <td> Supplier Name </td> --}}
                <td > Supplier Name:  <span style="font-weight: bold">{{ $data[0]->supname }}</span> </td>
                <td > Invoice No:  <span style="font-weight: bold">{{ $data[0]->invoiceno }}</span> </td>
                <td > Invoice Date:  <span style="font-weight: bold">{{ $data[0]->invoice_date }}</span> </td>

                {{-- <td> Invoice No </td>
                <td style="font-weight: bold" > {{ $data[0]->invoiceno }}</td> --}}

                {{-- <td > Invoice Date  </td>
                <td style="font-weight: bold"> {{ $data[0]->invoice_date }} </td> --}}
            </tr>
        </tbody>
    </table>

    <table class="ledger">
        <tbody>
            <tr>
                <td > Supplier Address:  <span style="font-weight: bold">{{ $data[0]->address }}</span> </td>
                <td > G.R No:  <span style="font-weight: bold">{{ $data[0]->gpassno }}</span> </td>
                {{-- <td> Supplier Address </td>
                <td style="font-weight: bold"> {{ $data[0]->address }} </td> --}}

                {{-- <td> G.R No </td>
                <td style="font-weight: bold" > {{ $data[0]->gpassno }}</td> --}}
            </tr>
        </tbody>
    </table>















    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="39%">Description Of Items</th>
                    <th class="column-headers" width="10%">Quantity</th>
                    <th class="column-headers" width="5%">Unit</th>
                    <th class="column-headers" width="25%">ForCustomer</th>
                    <th class="column-headers" width="9%">Rate</th>
                    <th class="column-headers" width="9%">Amount</th>
                {{-- </td> --}}
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $vtotpcs = 0 }} --}}
            {{ $vwt = 0 }}
            {{ $vvlues = 0 }}
            {{$srno=0}}

            @for ($i = 0 ; $i < count($data) ; $i++)

            @if ($i >0)
                {{ $srno = $i - 1 }}
            @endif

            <tr >
                {{ $vwt += $data[$i]->purqty }}
                {{ $vvlues += $data[$i]->vlues }}

                <td style=" border-top: 1px solid lightgray;  text-align:center" width="3%">{{ $i+1 }}</td>
                <td style=" border-top: 1px solid lightgray; text-align:left" width="39%">{{ $data[$i]->material_title }} </td>
                <td style=" border-top: 1px solid lightgray; text-align:right" width="10%">{{ number_format($data[$i]->purqty,1) }} </td>
                <td style=" border-top: 1px solid lightgray; text-align:center" width="5%">{{ $data[$i]->unit }} </td>
                <td style=" border-top: 1px solid lightgray; text-align:center" width="25%">{{ $data[$i]->forcust }} </td>
                <td style=" border-top: 1px solid lightgray; text-align:right" width="9%">{{ number_format($data[$i]->price,1) }} </td>
                <td style=" border-top: 1px solid lightgray;text-align:right" width="9%">{{ number_format($data[$i]->vlues,0) }} </td>

       {{-- </tr> --}}
        {{-- @if ($data[$i]->purid  <> $data[$srno]->purid) --}}
        @if ($i===$data[$i]->totrecd)
        <tr>
            <td style="color: white "  width="3%">0</td>
            <td  width="39%"> </td>
            <td  width="10%"> </td>
            <td  width="5%"> </td>
            <td  width="25%"> </td>
            <td  width="9%"> </td>
            <td  width="9%"> </td>
            </tr>


        @for ($a = 0 ; $a <= $data[$i]->cntblnkrw  ; $a++)
                <tr>
                <td style="color: white "  width="3%">0</td>
                <td  width="39%"> </td>
                <td  width="10%"> </td>
                <td  width="5%"> </td>
                <td  width="25%"> </td>
                <td  width="9%"> </td>
                <td  width="9%"> </td>
                </tr>
        @endfor

        @endif

       @endfor

            <tr>
                <td class="column-headers" colspan="2"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">Total</td>
                <td class="column-headers" colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td>
                <td class="column-headers" colspan="4"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td>
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
