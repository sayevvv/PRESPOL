<div class="flex flex-col space-y-1">
                                        <div class="block md:hidden flex flex-col items-start space-y-1 mb-1">
                                            <span class="text-sm font-semibold block">
                                                <?php echo $data['rank']; ?> - <?php echo $data['name']; ?>
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-10 md:h-12 relative">
                                            <div class="<?php echo $bgColor; ?> h-10 md:h-12 rounded-full flex items-center justify-between px-2 md:px-4 relative" style="width: <?php echo $widthPercentage; ?>%;">
                                                <span class="hidden md:block text-white font-bold text-xs md:text-base truncate">
                                                    <?php echo $data['rank']; ?> - <?php echo $data['name']; ?>
                                                </span>
                                                <span class="text-sm md:text-base text-white font-bold bg-white bg-opacity-20 px-2 py-1 rounded-full whitespace-nowrap">
                                                    <?php echo $data['points']; ?> &#9734;
                                                </span>
                                            </div>
                                        </div>
                                    </div>