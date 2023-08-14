<div>
    <span class="font-medium text-primary">{{ $filter->getFriendlyField() }}</span>
    <span class="text-gray-500">{{ ' ' . $filter->getFriendlyOperation() . ' ' }}</span>
    <code class="font-mono">{{ $filter->query }}</code>
</div>
