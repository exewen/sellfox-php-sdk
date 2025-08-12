<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Facade;

use Exewen\Facades\AppFacade;
use Exewen\Facades\Facade;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Sellfox\Contract\InboundInterface;

/**
 * 1.创建入库计划
 * @method static array createInboundPlan(array $params, array $header = []) 创建入库计划
 * @method static array taskProcess(string $task_id, array $header = []) 查询异步任务状态
 * 2.确定哪些 SKU 可以合并打包
 * @method static array generatePackingOptions(array $params, array $header = []) 生成装箱组选项
 * @method static array listPackingOptions(array $params, array $header = []) 查询装箱组选项
 * @method static array listPackingGroupItems(array $params, array $header = []) 查询装箱组商品
 * @method static array confirmPackingOption(array $params, array $header = []) 确认装箱选项
 * 3.提供箱内物品信息
 * @method static array setPackingInformation(array $params, array $header = []) 提交装箱信息
 * 4.生成并查看目的地运营中心选项
 * @method static array generatePlacementOptions(array $params, array $header = []) 生成入库配置项
 * @method static array listPlacementOptions(array $params, array $header = []) 查询入库配置项
 * 5.输入运输数据并生成运输选项
 * @method static array generateTransportationOptions(array $params, array $header = []) 生成运输承运人选项
 * 6.生成配送窗口选项
 * @method static array generateDeliveryWindowOptions(array $params, array $header = []) 生成预计送达时间窗口
 * 7.查看货件拆分和运输选项
 * @method static array listTransportationOptions(array $params, array $header = []) 查询运输承运人选项
 * @method static array listDeliveryWindowOptions(array $params, array $header = []) 查询预计送达时间窗口
 * @method static array getShipment(array $params, array $header = []) getShipment
 * 8.选择配送选项
 * @method static array confirmPlacementOption(array $params, array $header = []) 确认入库配置选项
 * 9.选择运输选项
 * @method static array confirmDeliveryWindowOptions(array $params, array $header = []) 确认预计送达时间窗口
 * @method static array confirmTransportationOptions(array $params, array $header = []) 确认运输承运人选项
 * 10.打印标签
 * @method static array getLabels(array $params, array $header = []) 打印外箱标签
 * @method static array getBillOfLading(array $params, array $header = []) 打印BOL文件
 * 11.将您的货件发送到亚马逊物流网络  listInboundPlanBoxes(array $params, array $header = []) listInboundPlanBoxes
 * 12.提供追踪信息
 * @method static array updateShipmentTrackingDetails(array $params, array $header = []) 更新追踪编码
 * 取消入库计划
 * @method static array cancelInboundPlan(array $params, array $header = []) 取消入库计划
 * 查询
 * @method static array getInboundPlanList(array $params, array $header = []) 获取入库计划列表
 * @method static array getInboundPlanDetail(array $params, array $header = []) 入库计划详情
 */
class InboundFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return InboundInterface::class;
    }

    public static function getProviders(): array
    {
        AppFacade::getContainer()->singleton(InboundInterface::class);

        return [
            LoggerProvider::class,
            HttpProvider::class,
        ];
    }
}