function escapeHtml(unsafe) {
    return unsafe
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
 }
function mainEdit(target) {
  const editId = target.next().attr('name');
  const message = target.parent().next().text();
  target.parent().parent().html(editMessage(editId,message));
}
function editMessage(editId,message) {
  return `
  <form method="POST" action="./handle_edit.php" class="post-subs">
    <input type="hidden" value="${editId}"name="id">
    <textarea type="textarea" name="message" class="edit_message" placeholder="留言">${escapeHtml(message)}</textarea>
    <button class='cancel btn btn-success'>取消</button>
    <button class='edit_submit btn btn-success'>送出</button>
    <input type="hidden" value="${message}"name="message">
  </form>
  `
}
function mainCancel(target) {
  const getMessage = target.next().next().val();
  const getEditId = target.prev().val();
  target.parent().parent().html(cancel(getEditId,getMessage));
}
function cancel(getEditId,getMessage) {
  return `
    <div class="right">
      <button class="edit btn btn-success" name='${getEditId}' href= 'handle_edit.php?id=${getEditId}'>編輯 </button>
      <button name='${getEditId}' class="delete_btn btn btn-success" href= 'handle_delete.php?id=${getEditId}'> 刪除</button>
    </div>
    <pre>${escapeHtml(getMessage)}</pre>
  `
}
function deleteMessage(target) {
  const deleteId = target.attr('name');
  if (confirm('確定要刪除嗎')) {
    $.ajax({
      type: 'POST',
      url: 'handle_delete.php',
      data: {
        id: deleteId,
      },
    }).done((resp) => {
      const res = JSON.parse(resp);
      if (res.result === 'delete success') {
       target.closest('.comments').remove();
      }
    });
  }
}
function deleteSubMessage(target) {
  const deleteId = target.attr('name');
  if (confirm('確定要刪除嗎?')) {
    $.ajax({
      type: 'POST',
      url: 'handle_delete.php',
      data: {
        id: deleteId,
      },
    }).done((resp) => {
      const res = JSON.parse(resp);
      if (res.result === 'delete success') {
        target.closest('.sub-comment').remove();
      }
    });
  }
}
function mainPost (target){
  const comment = target.parent().find('textarea[name=message]').val();
  const parentId = target.parent().find('input[name=parent_id]').val();
  $.ajax({
    type: 'POST',
    url: 'handle_post.php',
    data: {
      message: comment,
      parent_id: parentId,
    },
  }).done((resp) => {
    const res = JSON.parse(resp);
    if (res.result === 'success') {
       $('.board_comment').after(postMessage(res.nickname, res.id, res.time, comment));
     }
  });
}
function postMessage(nickname, id, time, comment) {
  return `
  <div class="comments col-12">
    <div class="comment">
      <div class="name">
        <h3 class="mainName">${nickname}</h3>
        <span class="time">${time}</span>
      </div>
      <div>
        <div class="right">
          <button class="edit btn btn-success" name='${id}' href= 'handle_edit.php?id=${id}'>編輯 </button>
          <button name='${id}' class="delete_btn btn btn-success" href= 'handle_delete.php?id=${id}'> 刪除</button>
        </div>
        <pre>${escapeHtml(comment)}</pre>
      </div>
    </div>
    <form method="POST" action="./handle_post.php" class="post-sub">
       <h3 class="newSub">新增留言</h3>
       <input type="hidden" value="${id}"name="parent_id">
       <textarea type="textarea" name="message" class="user_sub_message" placeholder="留言"></textarea>
       <button class='sub_message_btn btn btn-primary'>送出</button>
    </form>
  </div>
  `;
}

function subPost(target) {
  const message = target.parent().find('textarea[name=message]').val();
  const parentId = target.parent().find('input[name=parent_id]').val();
  $.ajax({
    type: 'POST',
    url: 'handle_post.php',
    data: {
      message: message,
      parent_id: parentId,
    }
  }).done((resp) => {
    const res = JSON.parse(resp);
    const commentName = target.closest('.comments').find('.mainName').text();
    const subBackground = commentName === res.nickname ? 'background:#ffc4c1' : '';
    if (res.result === 'success') {
      target.closest('form').before(postSubMessage(subBackground, res.nickname, res.time, res.id, message));
    }
  });
}
function postSubMessage(subBackground, nickname, time, id, message) {
  return `
    <div class="sub-comments">
      <div class="sub-comment" style=${subBackground}>
        <div class="name">
          <h3>${nickname}</h3>
          <span class="time">${time}</span>
        </div>
        <div>
          <div class="right">
            <button class="sub_edit_btn btn btn-success" name='${id}' href= 'handle_edit.php?id=${id}'>編輯 </button>
            <button class="sub_delete_btn btn btn-success" name= '${id}' href= 'handle_delete.php?id=${id}'> 刪除</button>
          </div>
          <pre>${escapeHtml(message)}</pre>
        </div>
      </div>
    </div>
  `;
}
function mainSubmit (target) {
  const editSubmitMessage = target.parent().find('textarea[name=message]').val();
  const editSubmitId = target.parent().find('input[name=id]').val();
  $.ajax({
    type: 'POST',
    url: 'handle_edit.php',
    data: {
      message: editSubmitMessage,
      id: editSubmitId,
    }
  }).done((resp) => {
    const res = JSON.parse(resp);
    if (res.result === 'edit success')  {
      target.parent().parent().html(submitMessage(editSubmitId, editSubmitMessage));
    }
  });
}
function submitMessage(editSubmitId, editSubmitMessage) {
  return `
    <div class="right">
      <button class="edit btn btn-success" name='${editSubmitId}' href= ' edit.php?id=${editSubmitId}'>編輯 </button>
      <button name='${editSubmitId}' class="delete_btn btn btn-success" href= 'handle_delete.php?id=${editSubmitId}'> 刪除</button>
    </div>
    <pre>${escapeHtml(editSubmitMessage)}</pre>
  `;
}
function subEdit(target) {
  const subEditId = target.next().attr('name');
  const subEditMessage = target.parent().next().text();
  target.parent().parent().html(editSubMessage(subEditId, subEditMessage));
}
function editSubMessage(subEditId, subEditMessage) {
  return `
    <form method="POST" action="./handle_edit.php" class="post-subs">
      <input type="hidden" value="${subEditId}"name="id">
      <textarea type="textarea" name="message" class="edit_message" placeholder="留言">${escapeHtml(subEditMessage)}</textarea>
      <button class='sub_cancel btn btn-success'>取消</button>
      <button class='sub_edit_submit btn btn-success'>送出</button>
      <input type="hidden" value="${subEditMessage}"name="message">
    </form>
  `;
}
function subSubmit(target) {
  const subMessage = target.parent().find('textarea[name=message]').val();
  const subEditSubmitId = target.parent().find('input[name=id]').val();
  $.ajax({
    type: 'POST',
    url: 'handle_edit.php',
    data: {
      message: subMessage,
      id: subEditSubmitId,
    }
  }).done((resp) => {
    const res = JSON.parse(resp);
    if (res.result === 'edit success') {
      target.parent().parent().html(submitSubEdit(subEditSubmitId, subMessage));
    }
  });
}
function submitSubEdit(subEditSubmitId, subMessage) {
  return `
    <div class="right">
      <button class="sub_edit_btn btn btn-success" name='${subEditSubmitId}' href= 'handle_edit.php?id=${subEditSubmitId}'>編輯 </button>
      <button class="sub_delete_btn btn btn-success" name= '${subEditSubmitId}' href= 'handle_delete.php?id=${subEditSubmitId}'> 刪除</button>
    </div>
    <pre>${escapeHtml(subMessage)}</pre>
  `;
}
function subCancel(target) {
  const getMessage = target.next().next().val();
  const getEditId = target.prev().val();
  target.parent().parent().html(cancelSubMessage(getMessage, getEditId));
}
function cancelSubMessage (getMessage, getEditId) {
  return `
    <div class="right">
      <button class="sub_edit_btn btn btn-success" name='${getEditId}' href= 'handle_edit.php?id=${getEditId}'>編輯 </button>
      <button name='${getEditId}' class="sub_delete_btn btn btn-success" href= 'handle_delete.php?id=${getEditId}'> 刪除</button>
    </div>
    <pre>${escapeHtml(getMessage)}</pre>
  `;
}
$(document).ready(() => {
  $('.container').on('click', 'button', (e) => {
    const target = $(e.target);
    if (target.hasClass('edit')) { // 編輯主留言
      mainEdit(target);
      return
    }
    if (target.hasClass('cancel')) { // 取消編輯主留言
      mainCancel(target);
      return
    }
    if (target.hasClass('delete_btn')) { // 主留言刪除
      e.preventDefault();
      deleteMessage(target);
      return
    }
    if (target.hasClass('sub_delete_btn')) { // 子留言刪除
      e.preventDefault();
      deleteSubMessage(target);
      return
    }
    if (target.hasClass('message_btn')) { // 發送主留言
      e.preventDefault();
      mainPost(target);
      return
    }
    if (target.hasClass('sub_message_btn')) { // 發送子留言
      e.preventDefault();
      subPost(target);
      return
    }
    if (target.hasClass('edit_submit')) { // 主留言編輯提交
      e.preventDefault();
      mainSubmit(target);
      return
    }
    if (target.hasClass('sub_edit_btn')) { // 編輯子留言
      subEdit(target);
      return
    }
    if (target.hasClass('sub_edit_submit')) { // 子留言編輯提交
      e.preventDefault();
      subSubmit(target);
      return
    } else if (target.hasClass('sub_cancel')) { // 取消編輯子留言
      e.preventDefault();
      subCancel(target);
      return
    }
  });

  $('.navbar').on('click','button', (e) =>{
    const target = $(e.target);
    if (target.hasClass('login')) {
      $('.loginPage').css('display','block');
      return
    }
    if (target.hasClass('reg')) {
      $('.registerPage').css('display','block');
      return
    }
  })
  $('.userPage').on('click','button', (e) => {
    $('.loginPage').toggle();
    $('.registerPage').toggle();

     if ($('.loginPage').css('display') == 'none') {
      $('.toggle').html('已有帳號!我要登入');
    } else {
      $('.toggle').html('沒有帳號?來去註冊');
    }
  })
});
