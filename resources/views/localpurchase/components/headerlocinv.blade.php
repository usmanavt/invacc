.<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>

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
    font-size: 4rem;
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

.ledger {
    border:1px solid lightgray;
    padding:2px;
    margin-top:5px;
    margin-bottom:5px;

}


</style>
</head>





{{-- <table>
    <tbody>
        <tr>
            <td  style="text-align: center;">
                <span style="font-size:2rem;font-weight:bold;magin:1px;">PRICE QUOTATION</span>
            </td>
        </tr>
    </tbody>
</table> --}}
{{-- To From --}}
{{-- <table>
    <tbody>
        <tr style="width:100%;"  >
            <td  style="width:60%;font-size:32px;" >  From  :  </td>
            <td style="width:10%;font-size:32px;"  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td  style="width:30;font-size:32px;" > To  :  </td>
        </tr>
        <tr align ="left" style="width:100%;"  >
            <td align ="left" style="width:100%;font-size:32px;">
                <h3> {{ $hdng1 }} </h3>
                <h6> {{ $hdng2 }} </h6>
            </td>
            <td style="width:10%;font-size:32px;"  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td align ="left" style="width:100%;font-size:32px;vertical-align: top;">
                <h3> {{ $data[0]->custname }} </h3>
                <h6> {{ $data[0]->custadrs }} </h6>
            </td>
        </tr>
    </tbody>
</table> --}}
{{-- Ledger Info --}}

<table class="column-headers1">
    <tbody>
        <tr  >
            <td >PURCHASE INVOICE  </td>
        </tr>
        <tr  >
            <td style="font-size: 1rem" > MUHAMMAD NAZIR & Co </td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td  style="text-align: center;">
                <h3>Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                <h3>PLOT NO. E-13, S.I.T.E AREA KARACHI MOBILE NO. 0333-3804744" </h3>
                <h3>Phone : 021-32588781, 021-32574285 , Fax : 021-32588782 </h3>

            </td>            </tr>
    </tbody>
</table>





<table class="ledger">
    <tbody>
        <tr>
            {{-- <td> Supplier Name </td> --}}
            <td > Supplier Name:  <span style="font-weight: bold">{{ $data[0]->supname }}</span> </td>
            <td > Address:  <span style="font-weight: bold">{{ $data[0]->address }}</span> </td>
        </tr>
    </tbody>
</table>

<table class="ledger">
    <tbody>
        <tr>
            <td > Invoice No:  <span style="font-weight: bold">{{ $data[0]->invoiceno }}</span> </td>
            <td > Bill No:  <span style="font-weight: bold">{{ $data[0]->challanno }}</span> </td>
            <td > Invoice Date:  <span style="font-weight: bold">{{ $data[0]->invoice_date }}</span> </td>
            {{-- <td > G.R No:  <span style="font-weight: bold">{{ $data[0]->purinvsno }}</span> </td> --}}
            {{-- <td > GatePass No:  <span style="font-weight: bold">{{ $data[0]->GRGP }}</span> </td> --}}
        </tr>
    </tbody>
</table>

<table class="ledger">
    <tbody>
        <tr>
            <td > ItemCost:  <span style="font-weight: bold">{{ number_format($data[0]->itemcost,0) }}</span> </td>
            <td > {{ $data[0]->perdiscr }}: <span style="font-weight: bold">{{ $data[0]->discount }}</span> </td>
            <td > Cartage/Loading:  <span style="font-weight: bold">{{ $data[0]->cartload }}</span> </td>
            <td > Cut/Repair:  <span style="font-weight: bold">{{ number_format($data[0]->cutchrgs,0) }}</span> </td>
            <td > Payable:  <span style="font-weight: bold">{{ number_format($data[0]->payablechrgs,0) }}</span> </td>
        </tr>
    </tbody>
</table>
