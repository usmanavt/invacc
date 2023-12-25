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

.subhead{
    border:1px solid lightgray;

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
</style>


</head>
    <body>



        {{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}
    {{-- <table>
        <tbody>
            <tr>
                <td align="center" style="width:60%;">
                    <h1> MUHAMMAD NAZIR & Co </h1>
                </td>
                    &nbsp;&nbsp;&nbsp;&nbsp;
            </tr>
        </tbody>
    </table> --}}

    {{-- Address --}}
    {{-- <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.9rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.9rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.9rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">SALE RETURN HISTORY </span>
                </td>
            </tr>

        </tbody>
    </table>
 --}}

    {{-- Ledger Info --}}
    {{-- <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Date Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
            </tr>
        </tbody>
    </table> --}}

    {{-- column headers --}}
    <table class="column-headers">
        <thead>
            <tr>

                <th class="column-headers" width="3%">S#</th>
                <th class="column-headers" width="64%">Description Of Items</th>
                <th class="column-headers" width="10%">Quantity</th>
                <th class="column-headers" width="5%">Unit</th>
                {{-- <th class="column-headers" width="25%">ForCustomer</th> --}}
                <th class="column-headers" width="9%">Rate</th>
                <th class="column-headers" width="9%">Amount</th>



                </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $gtqty = 0 }};  {{ $gtval = 0 }}
            {{ $stqty = 0 }};  {{ $stval = 0 }}

@for ($i = 0 ; $i < count($data) ; $i++)

{{-- {{ $gtqty += $data[$i]->qty }} --}}
{{-- {{ $gtval += $data[$i]->saleamnt }} --}}




                @if( $i==0 )
                <tr>
                    <td class="subhead" colspan="2" width="100%"   > Customer Name: <span style="font-weight: bold;color:brown" > {{ $data[$i]->custname}} </span> </td>
                </tr>
                <tr>
                <td class="subhead" colspan="2" > Sale Date: <span style="font-weight: bold;color:brown">  {{ $data[$i]->saldate}} &nbsp;&nbsp;  </span>
                    DC No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->dcno}} &nbsp;&nbsp;&nbsp;&nbsp; </span>
                    Sale Return Date: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->podate}} &nbsp;&nbsp; </span>
                    Sale Return No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->billno}} </span>
                </td>
                </tr>


                @else

            {{ $srno = $i - 1 }}
            {{-- {{ $stqty += $data[$srno]->qty }} --}}
            {{-- {{ $stval += $data[$srno]->saleamnt }} --}}


        @if ($data[$i]->id  <> $data[$srno]->id)

            {{-- <tr>
                <td class="column-headers" colspan="2" width="100%" style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total</td>
                <td class="column-headers" colspan="1" width="8%" style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stqty,0) }} </td>
                <td class="column-headers" colspan="4" width="10%" style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stval,0) }} </td>
            </tr> --}}

            <tr>
                <td class="subhead" colspan="2" width="100%"   > Customer Name: <span style="font-weight: bold;color:brown" > {{ $data[$i]->custname}} </span> </td>
            </tr>
            <tr>
            <td class="subhead" colspan="2" > Sale Date: <span style="font-weight: bold;color:brown">  {{ $data[$i]->saldate}} &nbsp;&nbsp;  </span>
                DC No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->dcno}} &nbsp;&nbsp;&nbsp;&nbsp; </span>
                Sale Return Date: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->podate}} &nbsp;&nbsp; </span>
                Sale Return No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->billno}} </span>
            </td>
            </tr>


             {{ $stqty = 0 }};  {{ $stval = 0 }}
        @endif
        @endif

.
            <tr>


                {{-- {{ $debitusd += $data[$i]->DebitAmtDlr }}
                {{ $creditusd += $data[$i]->CreditAmtDlr }} --}}

                  @if($data[$i]->grpid == 2 || $data[$i]->grpid == 7 )
                  {
                    <td style="text-align: center;background:lightskyblue;font-weight: bold;"  width="3%">{{ $i+1 }}</td>
                    <td style="background: lightskyblue;font-weight: bold;color:brown;"  width="64%">{{ $data[$i]->matname }} </td>
                    <td style="text-align: right;background: lightskyblue;font-weight: bold;color:brown"  width="10%">{{ number_format($data[$i]->qty,1) }} </td>
                    <td style="text-align: center;background:lightskyblue;font-weight: bold"  width="5%">{{ $data[$i]->UOM }} </td>
                    <td style="background: lightskyblue;font-weight: bold;color:brown"  width="9%">{{ number_format($data[$i]->price,1) }} </td>
                    <td style="background: lightskyblue;font-weight: bold;color:brown"  width="9%">{{ number_format($data[$i]->saleamnt,0) }} </td>
                  }

                  @elseif($data[$i]->grpid > 9  )
                  {
                    <td style="text-align: center;background:lightgreen;font-weight: bold;"  width="3%">{{ $i+1 }}</td>
                    <td style="background: lightgreen;font-weight: bold;color:brown;"  width="64%">{{ $data[$i]->matname }} </td>
                    <td style="text-align: right;background: lightgreen;font-weight: bold;color:brown"  width="10%">{{ number_format($data[$i]->qty,1) }} </td>
                    <td style="text-align: center;background:lightgreen;font-weight: bold"  width="5%">{{ $data[$i]->UOM }} </td>
                    <td style="background: lightgreen;font-weight: bold;color:brown"  width="9%">{{ number_format($data[$i]->price,1) }} </td>
                    <td style="background: lightgreen;font-weight: bold;color:brown"  width="9%">{{ number_format($data[$i]->saleamnt,0) }} </td>
                  }





                  @else
                  {
                    <td style="text-align: center"  width="3%">{{ $i+1 }}</td>
                    <td  width="64%">{{ $data[$i]->matname }} </td>
                    <td style="text-align: right"  width="10%">{{ number_format($data[$i]->qty,1) }} </td>
                    <td style="text-align: center"  width="5%">{{ $data[$i]->UOM }} </td>
                    <td  width="9%">{{ number_format($data[$i]->price,1) }} </td>
                    <td  width="9%">{{ number_format($data[$i]->saleamnt,0) }} </td>
                  }
                  @endif

            </tr>
@endfor

{{-- {{ $stqty += $data[$srno+1]->qty }} --}}
{{-- {{ $stval += $data[$srno+1]->saleamnt }} --}}

{{-- <tr>
    <td colspan="2"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total</td>
    <td colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stqty,0) }} </td>
    <td colspan="4"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stval,0) }} </td>
</tr> --}}




{{-- <tr>
    <td colspan="2"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Grand Total(s)</td>
    <td colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtqty,0) }} </td>
    <td colspan="4"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtval,0) }} </td>
</tr> --}}



</tbody>
    </table>

    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;">
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

    </body> --}}
</html>
