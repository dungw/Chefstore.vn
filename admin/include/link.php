<?php
global $oDb;
$sql = "SELECT * FROM tbl_category ";
$rc = $oDb->query($sql);
$arrCat = $oDb->fetchAll($rc);


$sql = "SELECT id, name FROM tbl_product ";
$rc = $oDb->query($sql);
$arrProduct = $oDb->fetchAll($rc);

?>
<div class="table-list">
    <table>
        <tbody>
            <tr>
                <td colspan="2"><p><strong>Link Danh mục sản phẩm</strong></p></td>
            </tr>
            <?php
            $i = 0;
            foreach($arrCat as $key=>$value){
                $i++;
                $link = createLink('product',array('cid'=>$value['id'],'name'=>$value['name']));            
            ?>
            <tr>                
                <td><?php echo $i;?></td>
                <td><a href="<?php echo $link;?>" target="_blank"><?php echo $link;?></a></td>
            </tr>
            <?php
            }
            ?>
            <br /><br />
            <tr>
                <td colspan="2"><p><strong>Link sản phẩm</strong></p></td>
            </tr>
            <?php
            $i = 0;
            foreach($arrProduct as $key=>$value){
                $i++;
                $link = createLink('product_detail',array('id'=>$value['id'],'name'=>$value['name']));            
            ?>
            <tr>                
                <td><?php echo $i;?></td>
                <td><a href="<?php echo $link;?>" target="_blank"><?php echo $link;?></a></td>
            </tr>
            <?php
            }
            ?>
            
        </tbody>
    </table>
</div>