<?
	include '../ap/bd.php';


	if(authuser()) {
	    $user_uid = authuser();
	} else {
	    $user_uid = $uuid;
	}



	if(isset($_POST['uuid']) && isset($_POST['id']) && isset($_POST['like'])) {
		$uuid = htmlspecialchars($_POST['uuid']);
		$id = htmlspecialchars($_POST['id']);
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_stars` WHERE `product_id`='$id' AND `user_uid` = '$uuid'");
        if(mysqli_num_rows($query) > 0) {
        	mysqli_query($GLOBALS['db'], "DELETE FROM `products_stars` WHERE `product_id`='$id' AND `user_uid` = '$uuid'");
			echo json_encode(array(
				'result' => true,
				'status' => false,
				'nums' => likes($uuid),
				'message' => '<i class="fa fa-trash" aria-hidden="true"></i> Удалено из избранного',
			));
        } else {
        	mysqli_query($GLOBALS['db'], "INSERT INTO `products_stars` (`product_id`, `user_uid`) VALUES ('$id', '$uuid')");
			echo json_encode(array(
				'result' => true,
				'status' => true,
				'nums' => likes($uuid),
				'message' => '<i class="fa fa-check"></i> Добавлено в избранное',
			));
        }
	}

	if(isset($_GET['citySet'])) {
		$_SESSION['city_set'] = val_string($_GET['citySet']);
		echo json_encode(array(
			'result' => true,
		));
	}

	if(isset($_POST['cartDelete']) && isset($_POST['uuid']) && isset($_POST['id'])) {
		$id = htmlspecialchars($_POST['id']);
		$uuid = htmlspecialchars($_POST['uuid']);

		$city = $GLOBALS['city'];
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `id`='$id' AND `user_uid` = '$uuid' AND `city_id` = '$city'");
        if(mysqli_num_rows($query) > 0) {
        	mysqli_query($GLOBALS['db'], "DELETE FROM `cart` WHERE `id`='$id' AND `user_uid` = '$uuid'");
			echo json_encode(array(
				'result' => true,
				'status' => false,
				'message' => '<i class="far fa-trash"></i> Удалено из корзины',
			));
        } else {
        	//mysqli_query($GLOBALS['db'], "INSERT INTO `cart` (`city_id`, `product_id`, `mod_id`, `user_uid`, `chars`) VALUES ('$city', '$uidd', '$mod', '$user_uid','$characteristics')");
			echo json_encode(array(
				'result' => false,
				'message' => 'Данного товара нет в корзине.',
			));
        }
	}

	// добавление продукта в карточку товара
	if(isset($_POST['cartAdd']) && isset($_POST['uuid']) && isset($_POST['modId']) && isset($_POST['productId']) && isset($_POST['nums'])) {
		$uuid = htmlspecialchars($_POST['uuid']);
		$productId = intval(htmlspecialchars($_POST['productId']));
		$modId = intval(htmlspecialchars($_POST['modId']));
		$nums = intval(htmlspecialchars($_POST['nums']));
		$cityId = $GLOBALS['city'];
		/*if(isset($_POST['chars'])) {
			$characteristics = mysqli_real_escape_string($GLOBALS['db'], json_encode($_POST['chars']));
		} else {
			$characteristics = null;
		}*/
		$productArr = products_id($productId);
		$productMods = product_mods($GLOBALS['city'], $productArr['uid']);
		$stockArr = stock($productArr, $productMods);

		if(count($productMods) > 0) {
			$modArr = products_mod($cityId, $modId);
			if($modId !== 0) {
			//if($modId !== 0 && count($modArr) > 0) {
				if($nums <= $modArr['stock']) {
			        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `product_id`='$productId' AND `mod_id`='$modId' AND `user_uid` = '$uuid' AND `city_id` = '$cityId'");
			        if(mysqli_num_rows($query) > 0) {
						echo json_encode(array(
							'result' => false,
							'message' => 'Данный товар уже есть в корзине.',
						));
			        } else {
			        	mysqli_query($GLOBALS['db'], "INSERT INTO `cart` (`city_id`, `product_id`, `mod_id`, `user_uid`, `nums`) VALUES ('$cityId', '$productId', '$modId', '$uuid', '$nums')");
						echo json_encode(array(
							'result' => true,
							'status' => true,
							'message' => '<i class="far fa-check"></i> Добавлено в корзину',
						));
			        }
				} else {
					echo json_encode(array(
						'result' => false,
						'message' => 'Указанное кол-во товара нет в наличии. Максимум '.$modArr['stock'].' ед.',
					));
				}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => 'Выберите тип товара',
				));
			}
		} else {
			if($productArr['stock'] > 0) {
				if($nums <= $productArr['stock']) {
					//добавляем
			        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `product_id` = '$productId' AND `mod_id` = 0 AND `user_uid` = '$uuid' AND `city_id` = '$cityId'");
			        if(mysqli_num_rows($query) > 0) {
						echo json_encode(array(
							'result' => false,
							'message' => 'Данный товар уже есть в корзине.',
						));
			        } else {
			        	mysqli_query($GLOBALS['db'], "INSERT INTO `cart` (`city_id`, `product_id`, `mod_id`, `user_uid`) VALUES ('$cityId', '$productId', '$modId', '$uuid')");
						echo json_encode(array(
							'result' => true,
							'status' => true,
							'message' => '<i class="far fa-check"></i> Добавлено в корзину',
						));
			        }
				} else {
					echo json_encode(array(
						'result' => false,
						'message' => 'Указанное кол-во товара нет в наличии. Максимум '.$productArr['stock'].' ед.',
					));
				}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => 'Данного товара нет в наличии.',
				));
			}
		}
	}

	if(isset($_POST['setCart']) && isset($_POST['id']) && isset($_POST['nums']) && isset($_POST['uuid']) && isset($_POST['cityId'])) {
		$uidd = val_string($_POST['uuid']);
		$id = val_string($_POST['id']);
		$nums = val_string($_POST['nums']); 
		$cityId = val_string($_POST['cityId']); 
		$nums = preg_replace("/[^0-9]/", '', $nums);
		if($nums > 0) {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$uidd' AND `id` = '$id' ORDER BY `regdate` LIMIT 0, 60"); 
            if(mysqli_num_rows($query) > 0) {
            	$row = mysqli_fetch_assoc($query);
				$summ = 0;
				$productArr = products_id($row['product_id']);
				$modArr = products_mod($cityId , $row['mod_id']);

                if(count($modArr) > 0) {
                    $stock = $modArr['stock'];
                    $summ = $modArr['price']*$nums;
                } else {
                    $stock = $productArr['stock'];
                    $summ = $productArr['price']*$nums;
                }
                $summ = $productArr['price']*$nums; // убрать если моды с прайсом

                if($nums <= $stock) {
                	mysqli_query($GLOBALS['db'], "UPDATE `cart` SET `nums`='$nums' WHERE `user_uid`='$uidd' AND `id` = '$id'");

					echo json_encode(array(
						'result' => true,
						'product_summ' => price($summ),
						'total_summ' => price(cartTotalSumm($uuid)['summ']),
						'total_summ_sale' => price(cartTotalSumm($uuid)['summ_sale']),
						'status' => false,
						'message' => '',
					));
                } else {
					echo json_encode(array(
						'result' => false,
						'id' => $id,
						'nums_max' => $stock,
						'message' => 'Указанное кол-во товара нет в наличии. Максимум '.$stock.' ед.',
					));
                }
            } else {
				echo json_encode(array(
					'result' => false,
					'message' => 'Товар не найден в корзине.',
				));
            }
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => 'Неверное значение кол-во данного товара.',
			));
		}
	}

	if(isset($_POST['setCart2']) && isset($_POST['id']) && isset($_POST['nums']) && isset($_POST['uuid'])) {
		$uidd = val_string($_POST['uuid']);
		$id = val_string($_POST['id']);
		$nums = val_string($_POST['nums']); 
		$nums = preg_replace("/[^0-9]/", '', $nums);

		if($nums > 0 && $nums <= 10000) {
			mysqli_query($GLOBALS['db'], "UPDATE `cart` SET `nums`='$nums' WHERE `user_uid`='$uidd' AND `id` = '$id'");


            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$uidd' ORDER BY `regdate` LIMIT 0, 60"); 
            if(mysqli_num_rows($query) > 0) {
                $summ = 0;
                while($row = mysqli_fetch_assoc($query)) {

                    $productArr = products_id($row['product_id']);
                    $modArr = products_mod($GLOBALS['city'], $row['mod_id']);

                    if(count($modArr) > 0) {
                        //$summ += $modArr['price']*$row['nums'];
                        $stock = $modArr['stock'];
                    } else {
                        //$summ += $productArr['price']*$row['nums'];
                        $stock = $productArr['stock'];
                    }

                    $summ += $productArr['price']*$row['nums']; // убрать если моды с прайсом



                    /*$idstr = $row['product_id'];
                    $mod_id = $row['mod_id'];
                    $postrow = array();
                    $postrow[0] = products_id($idstr);
                    $in = 0;   

                    $product2 = products_mod($GLOBALS['city'], $postrow[$in]['uid_moysklad'], $mod_id);
                    if($product2) {
                        $summ += $product2['price']*$row['nums'];
                        $products[$idstr]= $product2['price']*$row['nums'];
                    } else {
                        $summ += $postrow[$in]['price']*$row['nums']; 
                        $products[$idstr]= $postrow[$in]['price']*$row['nums'];
                    }*/
				echo json_encode(array(
					'result' => true,
					'message' => 'ok',
				));

                }
            } else {
				echo json_encode(array(
					'result' => false,
					'message' => 'Товар не найден в корзине.',
				));
            }

		    /*$arr_sale = array();
		    $arr_sale = $_SESSION['promocode'];

		    if($_SESSION['promocode']['result'] == true) {
		    	$html = '<s>'.number_format($summ, 0, '.', ' ').' &#8381;</s> &nbsp;<br><span class=sale-text>'.number_format(discount_payment($summ, $arr_sale['sale'], $_SESSION['balls']), 0, '.', ' ').' &#8381;</span>';
		    } else {
		    	$html = ''.number_format($summ, 0, '.', ' ').' &#8381;';
		    }

			echo json_encode(array(
				'result' => true,
				'product_summ' => number_format($products[$product_id], 0, '.', ' ').' &#8381;',
				'total_summ' => $html,
				'status' => false,
				'message' => '',
			));*/
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => 'Неверное значение кол-во данного товара.',
			));
		}
	}

	if(isset($_GET['cart_update'])) {
		if(cart_count($user_uid)['result'] == true) {
            echo json_encode(array(
                'summ' => cart_count($user_uid)['summ'].' &#8381;',
                'nums' => cart_count($user_uid)['nums'],
            ));
		} else {
            echo json_encode(array(
                'summ' => '',
                'nums' => 0,
            ));
		}
	}

	if(isset($_GET['getUserId'])) {
	    $userId = val_string($_GET['getUserId']);
	    $UDS = new UDSGame\UDSGame(settings()['0']['key_uds']);
	    $clientInfo = $UDS->getClientInfoById($userId);
	    if(!authuser()) {
	        echo json_encode(array(
	            'result' => false,
	            'message' => 'Ошибка, вы не авторизованы.'
	        ));
	    } else {
	        if($clientInfo == null) {
	            echo json_encode(array(
	                'result' => false,
	                'message' => 'Ошибка, попробуйте снова чуть позже.'
	            ));
	        } else {
	            if($clientInfo->{'errorCode'} == 'notFound') {
	                echo json_encode(array(
	                    'result' => false,
	                    'message' => 'Пользователь не найден.'
	                ));
	            } else {
	                $arr['result'] = true;
	                $arr['firstname'] = $clientInfo->{'name'};
	                $arr['lastname'] = $clientInfo->{'surname'};
	                $arr['scores'] = $clientInfo->{'scores'};
	                $arr['vip'] = $clientInfo->{'vip'};
	                $arr['id'] = $clientInfo->{'id'};
	                $arr['participantId'] = $clientInfo->{'participantId'};
	                $arr['dateCreated'] = $clientInfo->{'dateCreated'};
	                $arr['skype'] = $clientInfo->{'skype'};
	                $arr['instagram'] = $clientInfo->{'instagram'};
	                $arr['birthday'] = $clientInfo->{'birthday'};
	                $arr['gender'] = $clientInfo->{'gender'};
	                $arr['uid'] = $clientInfo->{'uid'};
	                $arr['birthDate'] = $clientInfo->{'birthDate'};
	                $arr['avatar'] = $clientInfo->{'avatar'};
	                $arr['participant'] = $clientInfo->{'participant'};
	                
	                if(uds_user($user_uid)['result'] == true) {
	                    $ss = mysqli_query($GLOBALS['db'], "UPDATE `accounts_uds` SET 
	                        `firstname`='".$arr['firstname']."', 
	                        `lastname`='".$arr['lastname']."', 
	                        `scores`='".$arr['scores']."', 
	                        `vip`='".$arr['vip']."', 
	                        `uid`='".$arr['id']."', 
	                        `birthDate`='".$arr['birthDate']."', 
	                        `dateCreated`='".$arr['dateCreated']."' WHERE `user_uid`='$user_uid'");
	                    echo $ss;
	                } else {
	                    mysqli_query($GLOBALS['db'], "INSERT INTO `accounts_uds` (`user_uid`, `firstname`, `lastname`, `scores`, `vip`, `uid`,`birthDate`,`dateCreated`) VALUES ('".$user_uid."', '".$arr['firstname']."', '".$arr['lastname']."', '".$arr['scores']."', '".$arr['vip']."', '".$arr['id']."', '".$arr['birthDate']."', '".$arr['dateCreated']."')");
	                }
	                echo json_encode($arr);
	            }
	        }
	    }
	}

	if(isset($_GET['getPromoCode'])) {
		$promoCode = val_string($_GET['getPromoCode']);
		if($promoCode) {
			$date = date('Y-m-d', time());
			$query = mysqli_query($GLOBALS['db'], "SELECT * FROM `coupon` WHERE `name` = '$promoCode' AND DATE(startdate) <= CURRENT_DATE() AND DATE(olddate) >= CURRENT_DATE()"); 
			if(mysqli_num_rows($query) > 0) {
				$row = mysqli_fetch_assoc($query);
	            $arr['result'] = true;
	            $arr['code'] = $promoCode;
	            $arr['sale'] = $row['value'];
	            $arr['message'] = 'Промокод активирован.';

				$_SESSION['promocode'] = $arr;

				echo json_encode($arr);
			} else {
		        echo json_encode(array(
		            'result' => false,
		            'message' => 'Данный промокод не активен либо не существует.'
		        ));
			}
		} else {
	        echo json_encode(array(
	            'result' => false,
	            'message' => 'Вы не указали.'
	        ));
		}
	}

	if(isset($_POST['getPromoCode']) && isset($_POST['getBalls'])) {
	    $promoCode = val_string($_POST['getPromoCode']);
	    $promoCode = $_SESSION['promocode']['code'];
	    $balls = val_string($_POST['getBalls']);
	    $UDS = new UDSGame\UDSGame(settings()['0']['key_uds']);
	    $clientInfo = $UDS->getClientInfoByCode($promoCode, $uuid);
	    $clientId = $clientInfo->id;
	    $promoCodeInfo = $UDS->parsePromoCode($promoCode, $uuid);

	    if($clientInfo == null) {
	        echo json_encode(array(
	            'result' => false,
	            'message' => 'Ошибка, попробуйте снова чуть позже.'
	        ));
	    } else {
	        if($clientInfo->{'errorCode'} == 'notFound') {
	            echo json_encode(array(
	                'result' => false,
	                'message' => 'Данный промокод не существует либо истек срок действительности.'
	            ));
	        } else {
	   
	            $arr['udsgame'] = true;
	            $arr['code'] = $promoCode;
	            $arr['clientId'] = $clientId;
	            $arr['sale'] = $promoCodeInfo->data->customer->discountRate;
	            $arr['scores'] = $promoCodeInfo->data->customer->scores;

	            if($arr['scores'] >= $balls) {
	            	$summ = (cart_count($user_uid)['summ']/100)*50;
	            	if($balls <= $summ) {
		            	$arr['result'] = true;
		            	$arr['balls'] = $balls;
		            	$_SESSION['balls'] = $balls;
	            	} else {
		            	$_SESSION['balls'] = 0;
		            	$arr['result'] = false;
		            	$arr['message'] = 'Баллами можно оплатить только до 50% от итоговой суммы заказа.';
	            	}
	            } else {
	            	$_SESSION['balls'] = 0;
	            	$arr['result'] = false;
	            	$arr['message'] = 'У вас нет столько баллов.';
	            }
	            
	            echo json_encode($arr);
	        }
	    }
	}

	if(isset($_POST['delPromoCode'])) {
		$_SESSION['balls'] = 0;
		$_SESSION['promocode'] = 0;
		echo json_encode(array(
			'result' => true,
		));
	}

	if(isset($_POST['userupdate'])) {
	    $firstname = val_string($_POST['firstname']);
	    $lastname = val_string($_POST['lastname']);
	    //$phone_old = val_string($_GET['phone']);
	    //$phone = preg_replace("/[^0-9]/", '', $phone_old);
	    $email = val_string($_POST['email']);
	    $city = val_string($_POST['city']);
	    $post = val_string($_POST['post']);
	    $address = val_string($_POST['address']);

	    if(authuser()) {
		    $query = mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`city`='$city',`post`='$post',`address`='$address' WHERE `uid`='$uuid'");

		    if($query) {
				echo json_encode(array(
					'result' => true,
					'message' => 'Информация успешно обновлена',
				));
		    } else {
				echo json_encode(array(
					'result' => false,
					'message' => 'Ошибка, попробуйте снова чуть позже.',
				));
		    }
	    } else {
			echo json_encode(array(
				'result' => false,
				'message' => 'Ошибка, вы не авторизованы',
			));
	    }
	}

	if(isset($_GET['order'])) {
		header('Content-type: application/json; charset=utf-8');

	    $firstname = val_string($_GET['firstname']);
	    $lastname = val_string($_GET['lastname']);
	    $phone_old = val_string($_GET['phone']);
	    $phone = preg_replace("/[^0-9]/", '', $phone_old);
	    $email = val_string($_GET['email']);
	    $city = val_string($_GET['city']);
	    //$city = 1;
	    $post = val_string($_GET['post']);
	    $type_pay = val_string($_GET['pay']);
	    $type_pay = preg_replace("/[^0-9]/", '', $type_pay);
	    $address = val_string($_GET['address']);
	    $comment = val_string($_GET['comment']);
	    $delivery = val_string($_GET['delivery']);
	    $delivery = preg_replace("/[^0-9]/", '', $delivery);

	    if($firstname && $lastname && $phone && $email && $city && $post && $address) {


            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$user_uid' ORDER BY `regdate` LIMIT 0, 60"); 
            if(mysqli_num_rows($query) > 0) {
			    $arr_sale = array();
			    $arr_sale = $_SESSION['promocode'];
			    $city_id = 1;
                $positionsArr = array();
                $summ = 0;
                $weight = 0;
                $deliverySumm = 0;
                $i = 0;
                while($row_products_top = mysqli_fetch_assoc($query)) {
                    $idstr = $row_products_top['product_id'];
                    $postrow = array();
                    $postrow[0] = products_id($idstr);
                    $modArr = products_mod($GLOBALS['city'], $row_products_top['mod_id']);
                    $in = 0;   
                    if(stock($postrow[$in], $modArr)['result']) {
                        $summ += $postrow[$in]['price']*$row_products_top['nums'];
                        if($postrow[0]['type']) {
                            $weight += $row_products_top['nums'];
                        } else {
                            $weight += $postrow[$in]['weight']*$row_products_top['nums'];
                        }
                        $summ_product = $postrow[$in]['price']*$row_products_top['nums'];

                        $positionsArr[$i]['product_id'] = $postrow[$in]['id'];
                        $positionsArr[$i]['mod_id'] = $row_products_top['mod_id'];
                        //$positionsArr[$i]['title'] = $postrow[$in]['title'];
                        $positionsArr[$i]['nums'] = $row_products_top['nums'];
                        $positionsArr[$i]['summ'] = $summ_product;

                        $i++;
                    } else {
                        $summ_product = 0;
                    }
                }

                $weight = floatval($weight);
                $weight + 100;

                if($delivery == 1) {
                    $deliveryArr = russianPost('630082', $post, $weight, 26, 17, 8);
                } else if($delivery == 2){
                    $deliveryArr = sdek('630082', $post, round(($weight*0.1)/100, 3), 26, 17, 8, 136);
                } else if($delivery == 3){
                    $deliveryArr = sdek('630082', $post, round(($weight*0.1)/100, 3), 26, 17, 8, 137);
                } else if($delivery == 4){
                    $deliveryArr = delivery('630082', $post);
                }

				if($delivery > 0) {
					if($deliveryArr['result'] && intval($deliveryArr['price']) > 0) {
						$deliverySumm = intval($deliveryArr['price'])+intval(settings()['0']['delivery']);
						$type_pay = 1;
					} else {
						echo json_encode(array(
							'result' => false,
							'message' => 'Ошибка, при оформлении заказа',
							'get' => json_encode($_GET),
						));
						exit();
					}
				} else {
					$delivery = 0;
					$type_pay = 0;
				}

			    $total_summ = intval(discount_payment($summ, $arr_sale['sale'])+$deliverySumm);

                $products = mysqli_real_escape_string($GLOBALS['db'], json_encode($positionsArr));
                $promocode = $arr_sale['code'];

                if($type_pay) {
                	$status = 1;
	            	$query_pay = mysqli_query($GLOBALS['db'], "INSERT INTO `pays` (`summ`) VALUES ('$total_summ')"); 
	            	$query_pay_id = mysqli_insert_id($GLOBALS['db']);
                } else {
                	$status = 2;
                	$query_pay_id = 0;
                }

				if($query_id == ''){ 
					$query_insert = mysqli_query($GLOBALS['db'], "INSERT INTO `order` (
						`firstname`, 
						`lastname`, 
						`phone`, 
						`email`, 
						`city`, 
						`city_id`, 
						`post`, 
						`address`, 
						`comment`, 
						`delivery`, 
						`delivery_price`,
						`summ`, 
						`total_summ`, 
						`products`, 
						`promocode`, 
						`type_pay`,
						`payment_id`,
						`status`
						) VALUES (
						'$firstname', 
						'$lastname', 
						'$phone', 
						'$email', 
						'$city', 
						'$city_id', 
						'$post', 
						'$address', 
						'$comment', 
						'$delivery', 
						'$deliverySumm',
						'$summ', 
						'$total_summ',
						'$products', 
						'$promocode', 
						'$type_pay',
						'$query_pay_id',
						'$status')");
					$query_id = mysqli_insert_id($GLOBALS['db']);
				}

				if($query_insert) {

					updateStock($user_uid);

					//$result = mysqli_query($GLOBALS['db'], "DELETE FROM `cart` WHERE `user_uid` = '$user_uid'");

					$token = "476421379:AAEoviECRe3Ugul9FJYcl43dOSOCFE1Kc7o";
					$chat_id = "-1001423120384"; //68148927 -234747814

					$subject = "Поступил заказ №".$query_id;
					$message = "{$subject} \r\n";
					$message .= "Сумма заказа: {$total_summ} \r\n";
					$message .= "Оплата: {$arrPay[$type_pay]} \r\n";
					$message .= "\nПодробнее: https://aiwayarn.com/ap/?page=order&id={$query_id} \r\n";

					$resultTelegram = sendTelegram($token, $chat_id, $message);

					$message = wordwrap($message, 200, "\r\n");
					$headers = 'Content-type: text/plain; charset="utf-8"';
					$send_mail = smtpmail('', settings($GLOBALS['city'])['0']['email'], $subject, $message, 'server@seenve.ru', '1');


					if($arr_sale['result']) {
						echo json_encode(array(
							'result' => true,
							'url' => '/order/'.$query_id,
							'message' => 'Заказ принят.',
							'products' => $arr_products,
							'delivery_summ' => $delivery_summ,
							'summ' => $summ,
							'total_summ' => $total_summ,
							'balls' => $balls,
							'promocode' => $arr_sale,
							'operation_uds' => $operation,
							'order_id' => $query_id,
							'type_pay' => $type_pay,
						));

						$_SESSION['promocode'] = false;
					} else {
						echo json_encode(array(
							'result' => true,
							'url' => '/order/'.$query_id,
							'message' => 'Заказ принят.',
							'order_id' => $query_id,
							'type_pay' => $type_pay,
						));
					}
				} else {
					echo json_encode(array(
						'result' => false,
						'message' => 'Не удалось расчитать стоимость посылки. Пожалуйста, обновите страницу.',
						'get' => json_encode($_GET),
						'price' => $deliveryArr['price'],
					));
				}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => 'Ошибка, у вас нет товаров в корзине',
				));
			}

	    } else {
			echo json_encode(array(
				'result' => false,
				'message' => 'Все поля обязательны к заполнению.',
			));
	    }
	}

	if(isset($_POST['auth'])) {
		$hash = md5(generate_code(10));
		$page = urlencode($_POST['pageto']);
	    $login = val_string($_POST['username']);
	    $phone = preg_replace("/[^0-9]/", '', $login);
	    $phone = preg_replace('/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/','\2\3\4\5',(string)$phone);
	    $phone = '7'.$phone;
	    $password = md5(val_string($_POST['password']));
		
		if($login) {
			if($password) {
				$query_account = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `email` = '$login' OR `uid` = '$login' OR `phone` = '$phone' ORDER BY id");
			    if(mysqli_num_rows($query_account) > 0) {
			    	$row_user = mysqli_fetch_assoc($query_account);
			    	$user_uid = $row_user['uid'];
			    	$user_email = $row_user['email'];
			    	$user_code = $row_user['code'];
			    	$user_firstname = $row_user['firstname'];
			    	if($password == $row_user['password']) {
		    			if($row_user['verify']) {
				    		mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `hash`='$hash' WHERE `uid`='$user_uid'");

				    		$_SESSION['userhash'] = $hash;
							$_SESSION['useruid'] = $user_uid;

							echo json_encode(array(
								'result' => true,
								'message' => ''
							));
		    			} else {
							echo json_encode(array(
								'result' => false,
								'message' => '<i class="fa fa-info"></i> Ошибка, вам нужно пройти регистрацию до конца.',
							));
		    			}
			    	} else {
						echo json_encode(array(
							'result' => false,
							'message' => '<i class="fa fa-info"></i> Неверный логин/пароль',
						));
					}
			    } else {
					echo json_encode(array(
						'result' => false,
						'message' => '<i class="fa fa-info"></i> Неверный логин/пароль',
					));
			    }

			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i> Введите пароль'
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i> Введите телефон или эл.почту'
			));
		}
	}

	if (isset($_POST['reg2'])) {
		$firstname = val_string($_POST['firstname']);
		$lastname = val_string($_POST['lastname']);
		$email = val_string($_POST['email']);
		$phone = val_string($_POST['phone']);
		$phone = preg_replace("/[^0-9]/", '', $phone);
		#$codep = htmlspecialchars($_POST['code']);
		$password = val_string($_POST['password']);
		$uid = md5(generate_code(10));
		$code = md5(generate_code(10));
		$captcha = val_string($_POST['captcha']);


			if(strlen($firstname) >= 2) {
				if(strlen($lastname) >= 2) {
					if (strlen($email) >= 7 && preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email)) {
						if(strlen($phone) == 11) {
							if (preg_match('/^[A-z0-9]{6,30}$/', $password)) {
								$query_email = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `email` = '$email'");
								$email_on = mysqli_fetch_assoc($query_email);
								if(!$email_on) {
									if(strlen($captcha) >= 1) {
										/*require_once "recaptchalib.php";
										$secret = "6LfevWoUAAAAAAkDHCtXKBsLreBIIZ28Jjnaeqkq";
										$response = null;
										$reCaptcha = new ReCaptcha($secret);
										if ($_POST["g-recaptcha-response"]) {
											$response = $reCaptcha->verifyResponse(
										        $_SERVER["REMOTE_ADDR"],
										        $_POST["g-recaptcha-response"]
										    );
										}
										if ($response != null && $response->success) {*/
										$captcha_server = $_COOKIE['imgcaptcha_'];
										$captcha = md5($captcha);
										if($captcha == $captcha_server) {
											$password_md5 = md5($password);

											mysqli_query ($GLOBALS['db'], "INSERT INTO `accounts` (`uid`, `password`, `firstname`, `lastname`, `email`, `phone`, `code`, `regdate`) VALUES ( '$uid', '$password_md5', '$firstname', '$lastname', '$email', '$phone', '$code', current_timestamp)"); 

											$subject = "Регистрация личного кабинета";
											$message .= "Здравствуйте, {$firstname}!<br><br><br>";
											$message .= "Вы успешно зарегистрировались!<br><br>";
											$message .= "Для активации личного кабинета, перейдите по ссылке:<br>";
											$message .= "<a href='https://".$_SERVER['SERVER_NAME']."/activate/{$code}'>https://".$_SERVER['SERVER_NAME']."/activate/{$code}</a><br><br>";
											$message .= "Если у вас возникнут какие-то трудности, обратитесь в службу поддержки.<br>";
											$message .= "-- \n";
											$message .= settings()['0']['title'];
											$send_mail = smtpmail($firstname, $email, $subject, $message, settings()['0']['email']);

											if($send_mail == 1) {
												echo json_encode(array(
													'result' => true,
													'message' => '<p><i class="fa fa-check"></i>Вы успешно зарегистрировались!</p><p>Для активации личного кабинета зайдите на свою эл.почту и перейдите по ссылке.</p>'
												));
											} else {
												echo json_encode(array(
													'result' => false,
													'message' => '<i class="fa fa-info"></i>Ошибка, попробуйте снова.',
												));
											}
										} else {
											echo json_encode(array(
												'result' => false,
												'message' => '<i class="fa fa-info"></i>Неверный код с картинки.<script>document.getElementById("captcha_img").src="/engine/captcha/index.php?id=" + (+new Date());</script>',
											));
										}
									} else {
										echo json_encode(array(
											'result' => false,
											'message' => '<i class="fa fa-info"></i>Код с картинки обязателен к заполнению.',
										));
									}
								} else {
									echo json_encode(array(
										'result' => false,
										'message' => '<i class="fa fa-info"></i>Данный E-mail уже зарегистрирован.',
									));
								}
							} else {
								echo json_encode(array(
									'result' => false,
									'message' => '<i class="fa fa-info"></i>Пароль должен состоять из латинский букв и цифр, не менее 6 символов'
								));
							}
						} else {
							echo json_encode(array(
								'result' => false,
								'message' => '<i class="fa fa-info"></i>Телефон обязателен к заполнению.'
							));
						}
					} else {
						echo json_encode(array(
							'result' => false,
							'message' => '<i class="fa fa-info"></i>Неверный формат эл.почты.'
						));
					}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i>Фамилия не может содержать меньше двух символов'
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i>Имя не может содержать меньше двух символов'
			));
		}
	}

	if (isset($_POST['reg'])) {
		$phone2 = val_string($_POST['phone']);
		$phone = preg_replace("/[^0-9]/", '', $phone2);
		$password = val_string($_POST['password']);
		$password_md5 = md5($password);
		$code2 = val_string($_POST['code']);
		$code= preg_replace("/[^0-9]/", '', $code2);
		$gen_code = generate_number(6);
		$hash = md5(generate_code(10));

		if(strlen($phone) == 11) {
			if (preg_match('/^[A-z0-9]{6,30}$/', $password)) {
				$query_phone = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `phone` = '$phone'");
				if(mysqli_num_rows($query_phone) > 0) {
					$row = mysqli_fetch_assoc($query_phone);
					if($row['verify']) {
						echo json_encode(array(
							'result' => false,
							'message' => '<i class="fa fa-info"></i> Данный телефон уже зарегистрирован.',
						));
					} else {
						// отправляем код

						if($code == $row['code']) {
				    		mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `hash`='$hash',`verify`='1',`code` = '0' WHERE `uid`='$user_uid'");

				    		$_SESSION['userhash'] = $hash;
							$_SESSION['useruid'] = $user_uid;

							echo json_encode(array(
								'result' => true,
								'code' => true,
								'message' => '<p><i class="fa fa-check"></i> Вы успешно зарегистрировались!</p><p>Для активации личного кабинета зайдите на свою эл.почту и перейдите по ссылке.</p>'
							));
						} else {
							mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `code`='$gen_code' WHERE `uid`='$user_uid'");

							$text = "Ваш проверочный код: {$gen_code}\n";
							$text .= "--\n";
							$text .= "AIWAYARN";

							$send_sms = sms($phone, $text);

							if($send_sms == true) {
								echo json_encode(array(
									'result' => false,
									'message' => '<i class="fa fa-info"></i> Ошибка, неверный код. Мы выслали вам новый код.',
								));
							} else {
								echo json_encode(array(
									'result' => false,
									'message' => '<i class="fa fa-info"></i> Ошибка отправки СМС, попробуйте чуть позже.',
								));
							}
						}
					}
				} else {
					// отправляем код и добавляем в бд

					//$result = mysqli_query ($GLOBALS['db'], "INSERT INTO `accounts` (`uid`, `password`, `phone`, `code`) VALUES ('$uuid', '$password_md5', '$phone', '$gen_code')");
					$result = mysqli_query ($GLOBALS['db'], "INSERT INTO `accounts` (`uid`, `password`, `phone`, `hash`, `code`, `verify`) VALUES ('$uuid', '$password_md5', '$phone', '$hash', 0, 1)");  // убрать если подключены смс

					$text = "Ваш проверочный код: {$gen_code}\n";
					$text .= "--\n";
					$text .= "AIWAYARN";

					$send_sms = sms($phone, $text);
					$send_sms = true; // убрать если подключены смс
		    		$_SESSION['userhash'] = $hash; // убрать если подключены смс
					$_SESSION['useruid'] = $user_uid; // убрать если подключены смс

					if($send_sms == true) {
						echo json_encode(array(
							'result' => $result,
							'code' => true, // поставить false если подключены смс
						));
					} else {
						echo json_encode(array(
							'result' => false,
							'message' => '<i class="fa fa-info"></i> Ошибка отправки СМС, попробуйте чуть позже.',
						));
					}

				}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i> Пароль должен состоять из латинский букв и цифр, не менее 6 символов'
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i> Телефон обязателен к заполнению.'
			));
		}
	}

	if (isset($_POST['reset'])) {
		$phone2 = val_string($_POST['phone']);
		$phone = preg_replace("/[^0-9]/", '', $phone2);
		$password = val_string($_POST['password']);
		$password_md5 = md5($password);
		$code2 = val_string($_POST['code']);
		$code = preg_replace("/[^0-9]/", '', $code2);
		$gen_code = generate_number(6);
		$hash = md5(generate_code(10));

		if(strlen($phone) == 11) {
			if (preg_match('/^[A-z0-9]{6,30}$/', $password)) {
				$query_phone = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `phone` = '$phone' AND `verify` = '1'");
				if(mysqli_num_rows($query_phone) > 0) {
					$row = mysqli_fetch_assoc($query_phone);

					if(strlen($code) >= 1) {
						if($code == $row['code']) {
				    		mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `hash`='$hash',`code` = '0' WHERE `phone`='$phone'");

				    		$_SESSION['userhash'] = $hash;
							$_SESSION['useruid'] = $row['uid'];

							echo json_encode(array(
								'result' => true,
								'code' => true,
								'message' => '<p><i class="fa fa-check"></i> Вы успешно зарегистрировались!</p><p>Для активации личного кабинета зайдите на свою эл.почту и перейдите по ссылке.</p>'
							));
						} else {
							mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `code`='$gen_code' WHERE `phone`='$phone'");

							$text = "Ваш проверочный код: {$gen_code}\n";
							$text .= "--\n";
							$text .= "ПИКФОРМЫ";

							$send_sms = sms($phone, $text);

							if($send_sms == true) {
								echo json_encode(array(
									'result' => false,
									'message' => '<i class="fa fa-info"></i> Ошибка, неверный код. Мы выслали вам новый код.',
								));
							} else {
								echo json_encode(array(
									'result' => false,
									'message' => '<i class="fa fa-info"></i> Ошибка отправки СМС, попробуйте чуть позже.',
								));
							}
						}
					} else {
						mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `code`='$gen_code' WHERE `phone`='$phone'");

						//$text = "Ваш проверочный код: {$gen_code}\n";
						//$text .= "--\n";
						$text .= "ПИКФОРМЫ";

						$send_sms = sms($phone, $text);

						if($send_sms == true) {
							echo json_encode(array(
								'result' => true,
							));
						} else {
							echo json_encode(array(
								'result' => false,
								'message' => '<i class="fa fa-info"></i> Ошибка отправки СМС, попробуйте чуть позже.',
							));
						}
					}
					
				} else {
					echo json_encode(array(
						'result' => false,
						'message' => '<i class="fa fa-info"></i> Данный профиль не зарегистрирован.',
					));
				}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i> Пароль должен состоять из латинский букв и цифр, не менее 6 символов'
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i> Телефон обязателен к заполнению.'
			));
		}
	}

	if(isset($_POST['reset_old'])) {
		$resetname = val_string($_POST['resetname']);
	    $phone = preg_replace("/[^0-9]/", '', $resetname);
	    $phone = preg_replace('/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/','\2\3\4\5',(string)$phone);
	    $phone = '7'.$phone;
	    $captcha = val_string($_POST['captcha']);
		if($resetname) {
			if(strlen($captcha) >= 1) {
				$captcha_server = $_COOKIE['imgcaptcha_'];
				$captcha = md5($captcha);
				if($captcha == $captcha_server) {
					$reset_query = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `email` = '$resetname' OR `uid` = '$resetname' OR `phone` = '$phone' ORDER BY id");
					$reset_row = mysqli_fetch_assoc($reset_query);
					if($reset_row) {
						$reset_email = $reset_row['email'];
						$reset_login = $reset_row['uid'];
						$reset_firstname = $reset_row['firstname'];
						$reset_uid = $reset_row['id'];
						$hash = md5(time().$reset_email);
						mysqli_query ($GLOBALS['db'], "UPDATE `accounts` SET `updatepassword` = '$hash' WHERE `id`='$reset_uid'");
						$subject = "Восстановление доступа";
						$message .= "Здравствуйте, {$reset_firstname}!\n\n";
						$message .= "Вы получили это письмо потому, что вы (либо кто-то, выдающий себя за вас) попросили выслать новый пароль к личному кабинету. Если вы не просили выслать пароль, то не обращайте внимания на это письмо, если же подобные письма будут продолжать приходить, обратитесь в службу поддержки.\n\n";
						$message .= "Для смены пароля перейдите по ссылке:\n";
						$message .= "https://".$_SERVER['SERVER_NAME']."/index.php?page=reset&mode=activate&uid={$reset_login}&key={$hash}\n\n";
						$message .= "Если у вас возникнут какие-то трудности, обратитесь в службу поддержки.\n\n";
						$message .= "-- \n";
						$message .= settings()['0']['title'];
						$send_mail = smtpmail('', $reset_email, $subject, $message, settings()['0']['email'], '1');
						if($send_mail == 1) {
							echo json_encode(array(
								'result' => true,
								'message' => '<i class="fa fa-check"></i><b>Информация по восстановлению пароля отправлена на e-mail *****'.substr($reset_email, 3).'</b><p>Дождитесь письма и следуйте описанным в нем инструкциям. Если Вы не получили письмо, попробуйте повторить процедуру восстановления.</p>'
							));
						} else {
							echo json_encode(array(
								'result' => false,
								'message' => '<i class="fa fa-info"></i>Ошибка отправки формы, попробуйте снова.',
							));
						}
					} else {
						echo json_encode(array(
							'result' => false,
							'message' => '<i class="fa fa-info"></i>По вашему запросу аккаунт <b>не найден.</b>',
						));
					}
				} else {
					echo json_encode(array(
						'result' => false,
						'message' => '<i class="fa fa-info"></i>Неверный код с картинки.<script>document.getElementById("captcha_img").src="/engine/captcha/index.php?id=" + (+new Date());</script>',
					));
				}
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i>Код с картинки обязателен к заполнению.',
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i>Некоторые поля не заполнены или содержат ошибки, проверьте правильность заполнения выделенных полей и повторите попытку.'
			));
		}
	}

	if(isset($_POST['reset2'])) {
		$uid = val_string($_POST['uid']);
		$key = val_string($_POST['key']);
		$password = val_string($_POST['password']);
		$query_res3 = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `uid`='$uid'");
		$row_res3 = mysqli_fetch_assoc($query_res3);
		$key2 = $row_res3['updatepassword'];
		$userId = $row_res3['id'];

		if($key == $key2) {
			if (preg_match('/^[A-z0-9]{6,30}$/', $password)) {
				$password_md5 = md5($password);
				mysqli_query ($GLOBALS['db'], "UPDATE `accounts` SET `password` = '$password_md5', `updatepassword` = '0' WHERE `id`='$userId'");
				echo json_encode(array(
					'result' => true,
					'message' => '<i class="fa fa-check"></i>Пароль успешно изменен.'
				));
			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i>Пароль должен состоять из латинский букв и цифр, не менее 6 символов'
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i>Ошибка восстановления, обратитесь в службу поддержки.'
			));
		}
	}

	if(isset($_POST['logout'])) {
		$login = val_string($_SESSION['useruid']);
		mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `hash`='0' WHERE `uid`='$login'");
		unset($_SESSION['userhash']);
		unset($_SESSION['useruid']);
		echo json_encode(array(
			'result' => true,
		));
	}


?>