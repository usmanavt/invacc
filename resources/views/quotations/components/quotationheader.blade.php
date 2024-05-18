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
            <td  style="width:60%;font-size:25px;" >  From  :  </td>
            <td style="width:10%;font-size:25px;"  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td  style="width:30;font-size:25px;" > To  :  </td>
        </tr>
        <tr align ="left" style="width:100%;"  >
            <td align ="left" style="width:100%;font-size:25px;">
                <h3> MUHAMMAD NAZIR & Co </h3>
                <h5> Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h5>
                <h5> PLOT NO. E-13, S.I.T.E AREA KARACHI MOBILE NO. 0333-3804744" </h5>
                <h5>Phone : 021-32588781, 021-32574285 , Fax : 021-32588782 </h5>
            </td>


            <td style="width:10%;font-size:25px;"  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td align ="left" style="width:100%;font-size:25px;vertical-align: top;">
                <h3> {{ $data[0]->custname }} </h3>
                <h6> {{ $data[0]->custadrs }} </h6>
            </td>
        </tr>
    </tbody>
</table>
{{-- Ledger Info --}}
{{-- <table class="ledger">
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
</table> --}}


<table style="Padding:5px; border:1.5px solid burlywood; "  >
    <tbody>
        <tr>

            <td >Quotation Date:  <span style="font-weight: bold"> {{ $data[0]->saldate }}</span>
            <td >Quotation No:  <span style="font-weight: bold"> {{ $data[0]->qutno }}</span>
            <td >P.R No:  <span style="font-weight: bold"> {{ $data[0]->prno }}</span>
            {{-- <td >P.O Date:  <span style="font-weight: bold"> {{ $data[0]->podate }}</span>
            <td >P.O Date:  <span style="font-weight: bold"> {{ $data[0]->podate }}</span>                 --}}
            <td >Valid Date:  <span style="font-weight: bold">{{ $data[0]->valdate }}</span>
        </tr>
    </tbody>
</table>




