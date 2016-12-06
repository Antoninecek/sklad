<table class="table table-hover" style="cursor: pointer">
    <tr>
        <td>id</td>
        <td>oscislo</td>
        <td>jmeno</td>
        <td>email</td>
        <td>aktivni</td>
        <td>admin</td>
        <td>datum</td>
    </tr>
    <?php
    foreach ($this->vsichniUzivatele as $a) {
        ?>
        <tr id="<?= $a['id'] ?>">
            <td><?= $a['id'] ?></td>
            <td><?= $a['oscislo'] ?></td>
            <td><?= $a['jmeno'] ?></td>
            <td><?= $a['email'] ?></td>
            <td><?= $a['aktivni'] ?></td>
            <td><?= $a['admin'] ?></td>
            <td><?= $a['datum'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>


<script type="text/javascript">

    $(document).ready(function () {
        $("table tr").on("click", function (e) {
            var winb = window.open("uzivatel/uprav/" + e.currentTarget.id, "popupWindow", "width=1200,height=500");
            while(!winb.closed){
                alert("zavri okno s upravou uzivatele");
            }
            window.location.replace("uzivatel/zobraz");
        });

    });


</script>