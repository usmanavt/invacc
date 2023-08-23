<table>
    <tbody>
        <tr>
            <td  style="text-align: center;">
                <span style="font-size:2rem;font-weight:bold;magin:1px;">PRICE QUOTATION</span>
            </td>
        </tr>
    </tbody>
</table>
{{-- To From --}}
<table>
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
</table>
{{-- Ledger Info --}}
<table class="ledger">
    <tbody>
        <tr>
            <td>
                Quotation No:
            </td>
            <td align ="left" style="font-size:12px;font-weight: bold"  >
                {{ $data[0]->qutno }}
            </td>
            <td >
                Quotation Date:
            </td>
            <td align ="left" style="font-size:12px;font-weight: bold">
                {{ $data[0]->saldate }}
            </td>
            <td>
                P.R No:
            </td>
            <td align ="left" style="font-size:12px;font-weight: bold">
                {{-- From {{ $fromdate }} to {{ $todate }} --}}
                {{ $data[0]->prno }}
            </td>

            <td>
                Valid Date:
            </td>
            <td align ="left" style="font-size:12px;font-weight: bold">
                {{ $data[0]->valdate }}
            </td>
        </tr>
    </tbody>
</table>
