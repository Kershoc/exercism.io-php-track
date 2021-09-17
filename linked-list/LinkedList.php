<?php

declare(strict_types=1);

class LinkedList
{
    private ?Node $head = null;
    private ?Node $tail = null;

    public function __construct()
    {
    }
    public function push($value)
    {
        $node = new Node($value);
        if ($this->tail) {
            $this->tail->setNext($node);
        } else {
            $this->head = $node;
        }
        $this->tail = $node;
    }

    public function pop()
    {
        $node = $this->tail;
        if ($node->prev) {
            $this->tail = $this->tail->unsetPrev();
        } else {
            $this->reset();
        }
        return $node->value;
    }
    public function shift()
    {
        $node = $this->head;
        if ($node->next) {
            $this->head = $this->head->unsetNext();
        } else {
            $this->reset();
        }
        return $node->value;
    }
    public function unshift($value)
    {
        $node = new Node($value);
        if ($this->head) {
            $this->head->setPrev($node);
        } else {
            $this->tail = $node;
        }
        $this->head = $node;
    }
    private function reset(): void
    {
        $this->head = null;
        $this->tail = null;
    }
}

class Node
{
    public ?Node $next = null;
    public ?Node $prev = null;

    public function __construct(public $value)
    {
    }
    public function setNext(Node $next): void
    {
        $next->prev = $this;
        $this->next = $next;
    }
    public function setPrev(Node $prev): void
    {
        $prev->next = $this;
        $this->prev = $prev;
    }
    public function unsetNext(): Node
    {
        $this->next->prev = null;
        return $this->next;
    }
    public function unsetPrev(): Node
    {
        $this->prev->next = null;
        return $this->prev;
    }
}
