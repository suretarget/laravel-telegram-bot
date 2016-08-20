<?php

namespace SumanIon\TelegramBot\Support;

use SumanIon\TelegramBot\Exceptions\SkipAction;

trait KnowsMultipleResponseTypes
{
    /**
     * Check if current response is an message response.
     *
     * @return boolean
     */
    public function isMessageResponse():bool
    {
        return isset($this->update->message);
    }

    /**
     * Check if current response is an edited_message response.
     *
     * @return boolean
     */
    public function isEditedMessageResponse():bool
    {
        return isset($this->update->edited_message);
    }

    /**
     * Check if current response is an inline_query response.
     *
     * @return boolean
     */
    public function isInlineQueryResponse():bool
    {
        return isset($this->update->inline_query);
    }

    /**
     * Check if current response is an chosen_inline_result response.
     *
     * @return boolean
     */
    public function isChosenInlineResultResponse():bool
    {
        return isset($this->update->chosen_inline_result);
    }

    /**
     * Check if current response is an callback_query response.
     *
     * @return boolean
     */
    public function isCallbackQueryResponse():bool
    {
        return isset($this->update->callback_query);
    }

    /**
     * Skip action if response is not an message response.
     *
     * @return void
     */
    public function respondsToMessages()
    {
        if (!$this->isMessageResponse()) {
            throw new SkipAction;
        }
    }

    /**
     * Skip action if response is not an edited_message response.
     *
     * @return void
     */
    public function respondsToEditedMessages()
    {
        if (!$this->isEditedMessageResponse()) {
            throw new SkipAction;
        }
    }

    /**
     * Skip action if response is not an inline_query response.
     *
     * @return void
     */
    public function respondsToInlineQueries()
    {
        if (!$this->isInlineQueryResponse()) {
            throw new SkipAction;
        }
    }

    /**
     * Skip action if response is not an chosen_inline_result response.
     *
     * @return void
     */
    public function respondsToChosenInlineResults()
    {
        if (!$this->isChosenInlineResultResponse()) {
            throw new SkipAction;
        }
    }

    /**
     * Skip action if response is not an callback_query response.
     *
     * @return void
     */
    public function respondsToCallbackQueries()
    {
        if (!$this->isCallbackQueryResponse()) {
            throw new SkipAction;
        }
    }

    /**
     * Match current command with the argument.
     *
     * @param  string $command
     *
     * @return bool
     */
    public function commandIs(string $command):bool
    {
        return $command === $this->update->command;
    }

    /**
     * Skip action if current command doesn't match.
     *
     * @param  string|array $command
     *
     * @return void
     */
    public function respondsToCommand($command)
    {
        $commands = (array)$command;

        foreach ($commands as $command) {
            if ($this->commandIs($command)) {
                return;
            }
        }

        throw new SkipAction;
    }

    /**
     * Alias for 'respondsToCommand' method.
     *
     * @param  array  $commands
     *
     * @return void
     */
    public function respondsToCommands(array $commands)
    {
        return $this->respondsToCommand($commands);
    }

    /**
     * Match current update's text with the argument.
     *
     * @param  string $text
     *
     * @return bool
     */
    public function textIs(string $text):bool
    {
        return $text === $this->update->text;
    }

    /**
     * Skip action if current update's text doesn't match.
     *
     * @param  string|array $text
     *
     * @return void
     */
    public function respondsTo($text)
    {
        $texts = (array)$text;

        foreach ($texts as $text) {
            if ($this->textIs($text)) {
                return;
            }
        }

        throw new SkipAction;
    }

    /**
     * Match current update's text with a pattern.
     *
     * @param  string $pattern
     *
     * @return bool
     */
    public function textMatches(string $pattern):bool
    {
        return !!preg_match($pattern, $this->update->text);
    }

    /**
     * Skip action if current update's text doesn't match.
     *
     * @param  string|array $pattern
     *
     * @return void
     */
    public function respondsToPattern($pattern)
    {
        $patterns = (array)$pattern;

        foreach ($patterns as $pattern) {
            if ($this->textMatches($pattern)) {
                return;
            }
        }

        throw new SkipAction;
    }

    /**
     * Alias for 'respondsToPattern' method.
     *
     * @param  array  $patterns
     *
     * @return void
     */
    public function respondsToPatterns(array $patterns)
    {
        return $this->respondsToPattern($patterns);
    }
}