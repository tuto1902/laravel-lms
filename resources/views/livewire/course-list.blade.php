<div>
    <table>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td> {{ $course->title }} </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
