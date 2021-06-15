<?php
/**
 * @link https://github.com/archaron/yii2-notisend
 * @copyright Copyright (c) 2021 Alexander Tischenko (tsm@archaron.ru)
 * @license https://github.com/archaron/yii2-notisend/blob/main/LICENSE
 */

namespace archaron\notisend\exceptions {

    use yii\base\Exception;

    /**
     * Base exception represents an exception that is caused during NotiSend requests.
     * @since 1.0
     */
    class BaseException extends Exception
    {
        /**
         * @return string the user-friendly name of this exception
         */
        public function getName()
        {
            return 'NotiSend base exception';
        }
    }
}
