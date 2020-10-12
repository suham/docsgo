
<div class="container-old">
<?php if (count($issues) == 0 && count($soup) == 0 && count($cybersecurity) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <div class="row">
      <div class="col-12">
          <div class="form-group" readonly="readonly">

              <!-- <input type="radio" name="issues-status-type" id="RDanchor1" onclick="javascript:window.location.href='/risk-assessment/view/1/1';" checked="<?php //echo $checkedVals['RDanchor1']; ?>"/> All 
              <input type="radio" name="issues-status-type" id="RDanchor2" onclick="javascript:window.location.href='/risk-assessment/view/1/2';" checked="<?php //echo $checkedVals['RDanchor2']; ?>"/> Open
              <input type="radio" name="issues-status-type" id="RDanchor3" onclick="javascript:window.location.href='/risk-assessment/view/1/3';" checked="<?php //echo $checkedVals['RDanchor3']; ?>"/> Close -->

              <input type="radio" name="issues-status-type" id="RDanchor1" 
              onclick="javascript:window.location.href='/risk-assessment/view/1/1';" <?php echo ($checkedVals['RDanchor1']) == 1 ? "checked" : ""; ?> /> All 
              <input type="radio" name="issues-status-type" id="RDanchor2" 
              onclick="javascript:window.location.href='/risk-assessment/view/1/2';"  <?php echo ($checkedVals['RDanchor2']) == 1 ? "checked" : ""; ?> /> Open
              <input type="radio" name="issues-status-type" id="RDanchor3" 
              onclick="javascript:window.location.href='/risk-assessment/view/1/3';" <?php echo ($checkedVals['RDanchor3']) == 1 ? "checked" : ""; ?> /> Close

          </div>
      </div>
    </div>

    <table class="table table-striped table-hover risk-assessment">
      <thead class="thead-dark" >
        <tr>
          <th scope="col">Category</th>
          <th scope="col">Risk</th>
          <th scope="col">Description</th>
          <th scope="col">Severity</th>
          <th scope="col">Occurrence</th>
          <th scope="col">Detectability</th>
          <th scope="col">RPN</th>
          <th scope="col">Update Date</th>
          <th scope="col" style="width:125px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($issues as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td> open-issue</td>
                <td><?php echo $row['issue'];?></td>
                <td><?php echo $row['issue_description'];?></td>
                <?php if (isset($row['severity'])): ?>
                  <td><?php echo $statusOptions[$row['severity']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['occurrence'])): ?>
                  <td><?php echo $statusOptions[$row['occurrence']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['detectability'])): ?>
                  <td><?php echo $statusOptions[$row['detectability']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <td><?php echo $row['rpn'];?></td>
                <td><?php echo $row['update_date'];?></td>
                <td>
                    <a href="/risk-assessment/add/1/<?php echo $row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php foreach ($cybersecurity as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td> Cybersecurity</td>
                <td><?php echo $row['reference']; ?></td>
                <td><?php echo $row['description'];?></td>
                <?php if (isset($row['severity'])): ?>
                  <td><?php echo $statusOptions[$row['severity']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['occurrence'])): ?>
                  <td><?php echo $statusOptions[$row['occurrence']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['detectability'])): ?>
                  <td><?php echo $statusOptions[$row['detectability']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <td><?php echo $row['rpn'];?></td>
                <td><?php echo $row['update_date'];?></td>
                <td>
                    <a href="/risk-assessment/add/2/<?php echo $row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php foreach ($soup as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td> Soup</td>
                <td><?php echo $row['soup'];?></td>
                <td><?php echo $row['purpose'];?></td>
                <?php if (isset($row['severity'])): ?>
                  <td><?php echo $statusOptions[$row['severity']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['occurrence'])): ?>
                  <td><?php echo $statusOptions[$row['occurrence']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['detectability'])): ?>
                  <td><?php echo $statusOptions[$row['detectability']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <td><?php echo $row['rpn'];?></td>
                <td><?php echo $row['update_date'];?></td>
                <td>
                    <a href="/risk-assessment/add/3/<?php echo $row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

<?php endif; ?>
</div>

