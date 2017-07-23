

                <!-- class col-md-4 col-sm-4 col-xs-12 -->
                <?php

                loadHelper(TEMPLATE);
                if($articles){
                    foreach ($articles as $value){
                        echo getTeamBlock($value,'col-md-4 col-sm-4 col-xs-12');
                    }
                }
                //vd($team);
                ?>
