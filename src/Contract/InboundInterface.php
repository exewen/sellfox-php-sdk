<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Contract;

interface InboundInterface
{
    public function createInboundPlan(array $params, array $header = []);
    public function taskProcess(string $task_id, array $header = []);

    public function generatePackingOptions(array $params, array $header = []);
    public function listPackingOptions(array $params, array $header = []);
    public function listPackingGroupItems(array $params, array $header = []);
    public function confirmPackingOption(array $params, array $header = []);
    public function setPackingInformation(array $params, array $header = []);
    public function generatePlacementOptions(array $params, array $header = []);
    public function generateTransportationOptions(array $params, array $header = []);
    public function generateDeliveryWindowOptions(array $params, array $header = []);
    public function listPlacementOptions(array $params, array $header = []);
    public function listTransportationOptions(array $params, array $header = []);
    public function listDeliveryWindowOptions(array $params, array $header = []);
    public function confirmPlacementOption(array $params, array $header = []);
    public function confirmDeliveryWindowOptions(array $params, array $header = []);
    public function confirmTransportationOptions(array $params, array $header = []);
    public function getLabels(array $params, array $header = []);
    public function getBillOfLading(array $params, array $header = []);
    public function updateShipmentTrackingDetails(array $params, array $header = []);
    public function getShipment(array $params, array $header = []);
    public function cancelInboundPlan(array $params, array $header = []);
    public function getInboundPlanList(array $params, array $header = []);
    public function getInboundPlanDetail(array $params, array $header = []);

}
