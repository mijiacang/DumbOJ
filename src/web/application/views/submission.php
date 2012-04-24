<div>
  <div class="status">
    <div style="min-width: 100%; overflow: auto">
      <table class="data status">
        <thead>
          <tr>
            <th style="width: 6em">ID</th>
            <th>User</th>
            <th>Problem</th>
            <th>Result</th>
            <th>Language</th>
            <th style="width: 8em">Time</th>
            <th style="width: 8em">Memory</th>
            <th style="width: 8em">Length</th>
            <th style="width: 14em">Submit at</th>
          </tr>
        </thead>
        <tbody>
<?php
      $s_user_id = $this->session->userdata('user_id');
      $s_privilege = $this->session->userdata('privilege');
      $error = null;
      if ($submission->is_shared !== '1' && !can_view_code($s_privilege) && (int)$submission->user_id !== $s_user_id) {
          $error = 'Sorry, this source code is private.';
      }
      $refresh = '';
      if (can_admin($s_privilege) || (int)$submission->result_key === get_result_key('System Error')) {
          $refresh = "<a href=\"problems/resubmit/{$submission->id}\"><img style=\"width: 1em; height: 1em\" src=\"images/refresh.png\" /></a>";
      }
?>
          <tr class="odd">
            <td><?php echo $submission->id; ?></td>
            <td><a href="user/profile/<?php echo $submission->username; ?>"><?php echo $submission->username; ?></a></td>
            <td><a href="problems/view/<?php echo $submission->problem_id; ?>"><?php echo htmlspecialchars($submission->original_site); ?> - <?php echo htmlspecialchars($submission->original_problem_id); ?></a></td>
            <td class="result<?php echo $submission->result_key; ?>"><?php echo $submission->result; ?><?php echo $refresh; ?></td>
            <td><?php echo htmlspecialchars($submission->language); ?></td>
            <td><?php echo $submission->time === null ? '' : "{$submission->time}MS"; ?></td>
            <td><?php echo $submission->memory === null ? '' : "{$submission->memory}KB"; ?></td>
            <td><?php echo $submission->length; ?>B</td>
            <td><?php echo $submission->submission_time; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="submission">
<?php if ($error === null && $submission->additional_info !== null) { ?>
    <div class="container info">
      <div class="title">Additional infomation</div>
      <hr />
      <pre class="info"><?php echo $submission->additional_info; ?></pre>
    </div>
<?php } ?>
    <div class="container info">
      <div class="title">Source code</div>
      <hr />
<?php if ($error === null) { ?>
      <div class="source_code">
        <pre class="<?php echo get_brush($submission->language_key); ?>"><?php echo htmlspecialchars($submission->source_code); ?></pre>
      </div>
<?php } else { ?>
      <div class="error"><?php echo $error; ?></div>
<?php } ?>
    </div>
  </div>
</div>
