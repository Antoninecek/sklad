<div>
    <div class="btn btn-default" onclick="zmenVyber('vsechny')">vsechny</div>
    <div class="btn btn-default" onclick="zmenVyber('vyreseno')">vyreseno</div>
    <div class="btn btn-default" onclick="zmenVyber('nevyreseno')">nevyreseno</div>
</div>

<div id="vsechny">
    <table class="table table-hover">
        <thead><h2>vsechny</h2></thead>
        <tr>
            <td>ID</td>
            <td>datum</td>
            <td>text</td>
            <td>vyreseno</td>
        </tr>
        <?php
        foreach ($this->logy as $a) {
            ?>
            <tr>
                <td><?php echo $a['ID'] ?></td>
                <td><?php echo $a['datum'] ?></td>
                <td><?php echo $a['text'] ?></td>
                <td><a href="logy/zmen/<?php echo $a['ID'] ?>/<?php echo $a['vyreseno'] ? 0 : 1 ?>"><span class="<?php echo $a['vyreseno'] ? 'glyphicon glyphicon-ok-circle' : 'glyphicon glyphicon-remove-circle' ?>"></span></a></td>
            </tr>



            <?php
        }
        ?>
    </table>
</div>

<div id="vyreseno" class="hidden">
    <table id="vyreseno" class="table table-hover">
        <thead><h2>vyreseno</h2></thead>
        <tr>
            <td>ID</td>
            <td>datum</td>
            <td>text</td>
            <td>vyreseno</td>
        </tr>
        <?php
        foreach ($this->logy as $a) {
            if ($a['vyreseno']) {
                ?>
                <tr>
                    <td><?php echo $a['ID'] ?></td>
                    <td><?php echo $a['datum'] ?></td>
                    <td><?php echo $a['text'] ?></td>
                    <td><a href="logy/zmen/<?php echo $a['ID'] ?>/<?php echo $a['vyreseno'] ? 0 : 1 ?>"><span class="<?php echo $a['vyreseno'] ? 'glyphicon glyphicon-ok-circle' : 'glyphicon glyphicon-remove-circle' ?>"></span></a></td>
                </tr>



                <?php
            }
        }
        ?>
    </table>
</div>


<div id="nevyreseno" class="hidden">
    <table id="nevyreseno" class="table table-hover">
        <thead><h2>nevyreseno</h2></thead>
        <tr>
            <td>ID</td>
            <td>datum</td>
            <td>text</td>
            <td>vyreseno</td>
        </tr>
        <?php
        foreach ($this->logy as $a) {
            if (!$a['vyreseno']) {
                ?>
                <tr>
                    <td><?php echo $a['ID'] ?></td>
                    <td><?php echo $a['datum'] ?></td>
                    <td><?php echo $a['text'] ?></td>
                    <td><a href="logy/zmen/<?php echo $a['ID'] ?>/<?php echo $a['vyreseno'] ? 0 : 1 ?>"><span class="<?php echo $a['vyreseno'] ? 'glyphicon glyphicon-ok-circle' : 'glyphicon glyphicon-remove-circle' ?>"></span></a></td>
                </tr>



                <?php
            }
        }
        ?>
    </table>
</div>

<script type="text/javascript">

    function zmenVyber($id) {
        document.getElementById("vsechny").className = "hidden";
        document.getElementById("vyreseno").className = "hidden";
        document.getElementById("nevyreseno").className = "hidden";
        document.getElementById($id).className = "show";
    }

</script>