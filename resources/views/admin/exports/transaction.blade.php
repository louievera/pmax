<table>
    <thead>
        <tr>
            <th>Creadted By</th>
            <th>Tracking No.</th>
            <th>Date</th>
            <th>Sender Name</th>
            <th>Sender Address</th>
            <th>Contact No.</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaction as $transaction)
        <tr>
            <td>{{ $transaction->user->fname }} {{ $transaction->user->lname }}</td>
            <td>{{ $transaction->tracking_no }} </td>
            <td>{{ $transaction->created_at }} </td>
            <td>{{ $transaction->sender->fname }}{{ $transaction->sender->lname }} </td>
            <td>{{ $transaction->sender->contact_no }} </td>
            <td>{{ $transaction->sender->address }} </td>
        </tr>
        @endforeach
    </tbody>
</table>