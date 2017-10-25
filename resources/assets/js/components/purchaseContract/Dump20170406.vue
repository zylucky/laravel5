<template>
    <div class="whole">
    <h1 class="tc">租赁资产管理合同</h1>
    <span class="tc f22">经纪成交版</span>
    <p>出租方（甲方）：<input type="text" style="width: 450px" disabled value=''/> </p>
    <p>承租方（乙方）：<input type="text" style="width: 450px" disabled value=""/>  </p>
    <p v-if="owner.farenzhengjian=='s'">居间方（丙方）：<input type="text" style="width: 450px" disabled v-model="owner.jujianfang"/></p>

    <p>&nbsp;&nbsp;依据《中华人民共和国合同法》及有关法律、法规的规定，甲、乙{{msg01}}方在平等、自愿的基础上，就乙方承租甲方房屋，{{msg02}}经各方友好协商一致，签订本合同以资信守。</p>
    <p><b>&nbsp;&nbsp; 第一条  房屋基本情况</b>
        <span
                v-for="(item,index) in property.officeList"
                :key="index"
        >
       &nbsp;（一）房屋坐落于北京市<u>{{item.weizhi?item.weizhi:'___________________________'}}</u>,承租区域建筑面积<u>{{item.jianzhumianji?item.jianzhumianji:'________'}}</u>平方米（最终以房屋所有权证标注的建筑面积为准），实际承租面积<u>{{item.qianyuemianji?item.qianyuemianji:'_______'}}</u>平方米。<br>
        &nbsp;（二）房屋权属状况：甲方持有（口 房屋所有权证/口 房屋买卖合同/口 商品房预售合同/口 二手房网签合同/口 其它房屋证明文件）,房屋所有权证书编号：<u>{{item.chanquanzhenghao?item.chanquanzhenghao:'____________________'}}</u>，房屋所有权人姓名或名称
            <span style="display: inline" v-for="(item,index) in owner.chanquanrenList">
                <u>{{item.name?item.name:'___________'}}</u>
            </span>房屋（
        口是/口否）已设定了抵押。甲方保证出租的房屋权属无瑕疵、无债务纠纷，房屋设施符合出租条件。<br><br>
         </span>
        <b>&nbsp;&nbsp; 第二条  房屋租赁情况</b><br>
        &nbsp;&nbsp;租赁用途：<u> 办公 </u>，甲方应当协助乙方（或实际使用人）办理营业证照。<br>
        <br><b>&nbsp;&nbsp; 第三条  租赁期限及免租期</b><br>
        &nbsp;（一）甲方承诺在租赁合同期限内给予乙方{{free_month>0?free_month:'__'}}个月 <span style="display: inline;" v-if="addDate.mianzuqiList[0].startdate"><u> {{free_day?free_day:''}} </u>日</span>的免租期，
        <span v-for="(item,index) in addDate.mianzuqiList" style="display:inline">
                自<u>&nbsp;&nbsp;{{year(item.startdate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.startdate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.startdate)}}&nbsp;&nbsp;</u>日至
                <u>&nbsp;&nbsp;{{year(item.enddate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.enddate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.enddate)}}&nbsp;&nbsp;</u>止；
        </span>
        免租期内乙方不支付租金，以便于乙方与入住方协商洽谈、进行装饰装修及办理入住手续等事宜。免租期内物业管理费用、供暖费和制冷费由甲方自行缴纳。<br>
        &nbsp;（二）本合同房屋租赁期限为
        <u v-if="nian">{{nian?nian:'__'}}</u><span v-if="nian" style="display: inline">年</span>
        <u v-if="yue">{{yue?yue:'__'}}</u><span v-if="yue" style="display: inline">月</span>
        <u v-if="ri>1">{{ri>1?ri:'__'}}</u><span v-if="ri>1" style="display: inline">日</span>。
        <span v-if="!nian&&!yue" style="display: inline">
                ____年__月__日
        </span>，

        自<u>&nbsp;&nbsp;{{year(addDate.startdate)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.startdate)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.startdate)}}&nbsp;&nbsp;</u>日至
        <u>&nbsp;&nbsp;{{year(addDate.enddate)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.enddate)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.enddate)}}&nbsp;&nbsp;</u>日止。<br>
        &nbsp;（三）甲方应于<u>&nbsp;&nbsp;{{year(addDate.jiaofangdate)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.jiaofangdate)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.jiaofangdate)}}&nbsp;&nbsp;</u>日前将房屋按约定条件交付给乙方。《房屋交割清单》经甲乙双方交验签字（盖章）确认及将房门钥匙移交视为交付完成。<br>
        &nbsp;（四）若合同期满乙方仍有承租人需使用该房屋，乙方应提前90天通知甲方，双方协商认可后签订延长期合同，本合同期限最长可自动顺延一年。在同等市场条件下，乙方拥有优先承租权。<br><br>

        <b>&nbsp;&nbsp; 第四条 租金和押金</b><br>
        &nbsp;（一）乙方按照下列标准向甲方支付租金（以人民币进行结算）：<br>
        <span v-for="(item,index) in addDate.zujinList">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                自<u>&nbsp;&nbsp;{{year(item.startdate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.startdate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.startdate)}}&nbsp;&nbsp;</u>日至
                <u>&nbsp;&nbsp;{{year(item.enddate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.enddate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.enddate)}}&nbsp;&nbsp;</u>日止，租金为人民币（大写）<u>&nbsp;&nbsp;{{daxie(item.yuezujin)}}&nbsp;&nbsp;</u> /月（￥：<u>&nbsp;&nbsp;{{toDecimal(item.yuezujin)?toDecimal(item.yuezujin):'__________'}}&nbsp;&nbsp;</u>元/月）；
            <br>
        </span>
        &nbsp;（二）租金支付方式为：
        <br>
        <span v-for="(item,index) in addDate.fukuanFangshiList"
              :key="index"
              style="display:inline"
        >

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <u>&nbsp;&nbsp;{{year(item.startdate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.startdate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.startdate)}}&nbsp;&nbsp;</u>日至
                <u>&nbsp;&nbsp;{{year(item.enddate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.enddate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.enddate)}}&nbsp;&nbsp;</u>日
                押 <u>{{item.yajinyue?intToChinese(item.yajinyue):'__'}}</u> 付 <u>{{item.zujinyue?intToChinese(item.zujinyue):'__'}}</u>;<br>

            </span>
        <br>
        &nbsp;1、房屋押金：<u> ¥ {{toDecimal(addDate.yajin)?toDecimal(addDate.yajin):'_____________'}}&nbsp;&nbsp;</u>元，（大写)：<u>{{daxie(addDate.yajin)?daxie(addDate.yajin):'__________'}}&nbsp;&nbsp;

            </u>元整，支付时间为<u>&nbsp;&nbsp;{{year(addDate.yajinfukuanri)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.yajinfukuanri)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.yajinfukuanri)}}&nbsp;&nbsp;</u>日支付;<br>
        &nbsp;2、押金是乙方向甲方支付的合法履约的保证金。租赁期满后5日内甲方退还乙方。<br>
        &nbsp;3、首期租金：¥ {{toDecimal(addDate.zujinList[0].yuezujin*addDate.fukuanFangshiList[0].zujinyue)>0?toDecimal(addDate.zujinList[0].yuezujin*addDate.fukuanFangshiList[0].zujinyue):'___________'}}元，（大写)：{{daxie(addDate.zujinList[0].yuezujin*addDate.fukuanFangshiList[0].zujinyue)?daxie(addDate.zujinList[0].yuezujin*addDate.fukuanFangshiList[0].zujinyue):'____________'}}，支付时间为
        <u>&nbsp;&nbsp;{{year(addDate.shouqifukuanri)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.shouqifukuanri)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.shouqifukuanri)}}&nbsp;&nbsp;</u>日前；租金每<u>{{addDate.fukuanFangshiList[0].zujinyue?addDate.fukuanFangshiList[0].zujinyue:'_____'}}</u>个月支付一次，于付款月起租日 <u>{{addDate.tiqianfukuantian}}</u> 日前支付下一次租金，
        即第二期租金的支付时间为：<u>&nbsp;&nbsp;{{year(addDate.erqifukuanri)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.erqifukuanri)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.erqifukuanri)}}&nbsp;&nbsp;</u>日;第三期租金的支付时间为 <u>&nbsp;&nbsp;{{year(addDate.sanqifukuanri)}}&nbsp;&nbsp;</u>年
        <u>&nbsp;&nbsp;{{month(addDate.sanqifukuanri)}}&nbsp;&nbsp;</u>月
        <u>&nbsp;&nbsp;{{day(addDate.sanqifukuanri)}}&nbsp;&nbsp;</u>日  ，合同期每期租金以此类推。<br>

        &nbsp;（三）租金的结算方式 口 以转账方式 口 现金支付<br>
        &nbsp;甲方指定收款账户为：<br>
        &nbsp;名&nbsp;称：<input type="text" style="width:500px;text-align:left" disabled v-model="owner.shoukuanren"><br>
        &nbsp;开户行：<input type="text" style="width:500px;text-align:left" disabled v-model="owner.kaihuhang"><br>
        &nbsp;账&nbsp;号：<input type="text" style="width:500px;text-align:left" disabled v-model="owner.zhanghao"><br><br>
        <b>&nbsp;&nbsp; 第五条 相关费用的承担方式</b> <br>
        &nbsp;（一） 甲方自行承担在承租期内及免租期内的物业管理费、供暖费、制冷费。<br>
        &nbsp;（二）在承租期内，乙方自行承担在使用期间的相关费用（水费、电费、燃气费、宽带费、停车费等），乙方按物业管理机构提供的交费通知单交费。<br>
        &nbsp;（三）在承租期内，乙方自行报装电话、宽带，相关费用由乙方自行承担。<br>
        &nbsp;（四）在承租期内，甲方应负责协助为乙方或房屋实际使用人开具房屋租金发票（增值税普通发票或增值税专用发票），发票需缴纳的税费由 □甲方 □乙方（或房屋实际使用人）承担。<br>
        &nbsp;（五）甲方同意，在承租期内，若乙方垫付了应由甲方支付的费用，乙方应出示相关缴费凭据并可在下次房屋租金中直接扣除。<br>  <br>
        <b>&nbsp;&nbsp; 第六条  甲方的权利义务</b> <br>
        &nbsp;（一）甲方应保证出租房屋的建筑结构和设备设施符合建筑、消防、电路、防水等方面的安全标准，不得危及乙方使用安全。<br>
        &nbsp;（二）在承租期内，如乙方或房屋实际使用人需要甲方出面配合或提供房屋权属证明等相关材料办理税务发票事宜时，甲方应予以出面配合或提供。<br>
        &nbsp;（三）甲方应当配合办理工商注册手续。甲方应于签约之日起{{beianqixian?beianqixian:'____'}}日内持房屋所有证或不动产权证及身份证原件去工商局备案。如甲方未能于签约之日起{{beianqixian?beianqixian:'____'}}日内进行备案，乙方有权不支付甲方房屋租金，直至甲方办理备案登记之日止。<br>
        &nbsp;（四）甲方保证乙方该房屋宽带网络可正常报装使用，如因原租户宽带网络未注销，影响正常报装使用宽带网络，甲方应在10日内解决。<br>
        &nbsp;（五）承租期内，该房屋主体结构、设备设施的维修责任。<br>
        &nbsp;&nbsp;&nbsp;对于该房屋的主要结构、固定管道线路及固定设施（包括制热、制冷、排风、上下水、电路及燃气等设施）发生自然损坏、故障或合理使用而导致的老化、耗损，乙方应及时通知甲方修复。甲方应在接到乙方通知后的5日内进行维修。逾期不维修的，乙方可代为维修，费用由甲方承担（乙方应出示相关维修支付凭据，并可在下次房屋租金中直接扣除）。<br>
        &nbsp;&nbsp;&nbsp;因上述原因进行维修的，在房屋恢复到正常使用前的期间，影响乙方无法正常使用，维修天数的租金由甲方承担，从支付甲方的下一次房租中扣除。<br>
        &nbsp;（六）在承租期内，甲方转让房屋应提前三个月通知乙方，乙方在同等价格条件下享有优先购买的权利。且甲方应与买受人对本合同进行交接完毕，不得影响乙方在本合同项下的权利义务。<br><br>
        <b>&nbsp;&nbsp; 第七条  乙方的权利义务</b> <br>
        &nbsp;（一）承租期内，甲方同意将乙方加价出租该房屋的溢价部分作为管理服务费由乙方收取，乙方收取租金高于支付甲方的租金部分用于对承租房屋进行装饰、装修、添置办公设备、设施等，但乙方不得拆除、破坏承租区域建筑的主体结构。 <br>
        &nbsp;（二）由于乙方装修或使用原因，导致房间的主要结构固定管道线路及设施发生损坏、故障乙方须及时修复或照价赔偿。<br>
        &nbsp;（三）甲方拖欠物业费或其它相关费用导致乙方不能正常使用的情况下，为保证乙方正常办理装修手续或正常使用，乙方可自行缴费，并可在下次房屋租金中直接扣除。<br><br>
        <b>&nbsp;&nbsp; 第八条  转租</b> <br>
        &nbsp;&nbsp;甲方同意乙方可在承租期内将房屋全部出租给第三方使用，乙方负责对第三方进行监督、管理，并自行承担与第三方的全部权利义务关系。<br><br>
        <b>&nbsp;&nbsp; 第九条  合同解除</b> <br>
        &nbsp;（一）经甲乙双方协商一致，可以解除本合同。<br>
        &nbsp;（二）因不可抗力导致本合同无法继续履行的，本合同自行解除。<br>
        &nbsp;（三）甲方有下列情形之一的，乙方有权单方解除合同；<br>
        &nbsp;&nbsp;1、甲方延迟交房10日。<br>
        &nbsp;&nbsp;2、交付的房屋不符合约定的使用条件或影响乙方安全、健康。<br>
        &nbsp;&nbsp;3、不承担约定的维修义务，致使乙方无法正常使用房屋达10日。<br>
        &nbsp;&nbsp;4、未提前说明重大安全隐患，如漏水、漏电等。<br>
        &nbsp;&nbsp;5、甲方未能配合乙方（或房屋实际使用人）开具增值税专用发票及增值税普通发票，以及违反本合同第六条约定的<br>
        &nbsp;&nbsp;6、此房屋因原租户或甲方营业执照未迁出等原因导致乙方或房屋实际使用人无法办理工商注册或迁址的。<br>
        &nbsp;&nbsp;7、甲方提前终止合同。<br>
        &nbsp;（四）乙方有下列情形之一的，甲方有权单方解除合同：<br>
        &nbsp;&nbsp;1、无故延迟支付租金达10日的。<br>
        &nbsp;&nbsp;2、擅自拆除或破坏房屋建筑主体结构。<br>
        &nbsp;&nbsp;3、利用房屋从事违法犯罪活动。<br>
        &nbsp;&nbsp;4、因装修造成房屋重大安全隐患。<br>
        &nbsp;&nbsp;5、乙方提前终止合同。<br><br>
        <b>&nbsp;&nbsp; 第十条  违约责任</b> <br>
        &nbsp;&nbsp;（一）甲方有第九条第（三）款约定的情形之一的，应按2个月租金为标准向乙方支付违约金，同时退还乙方已支付押金及未使用租期租金，如甲方违约仍需足额支付乙方对该房屋多次进行装饰、装修、添附设备、设施及乙方对他方赔偿所支付的全部费用。<br>
        &nbsp;&nbsp;（二）乙方有第九条第（四）款约定的情形之一的，应按2个月租金为标准向甲方支付违约金，甲方应退还乙方剩余押金及未使用租期租金。
        <br><br>
        <b>&nbsp;&nbsp; 第十一条 合同争议的解决办法</b> <br>
        &nbsp;&nbsp;本合同各项条款发生的争议，由双方当事人协商解决；协商不成的，依法向有管辖权的人民法院起诉，或按照另行达成的仲裁条款或仲裁协议申请仲裁。<br><br>
        <b>&nbsp;&nbsp; 第十二条 送达条款</b> <br>
        &nbsp;（一）甲乙双方一致同意，可通过在本合同中书写的手机号码以短信、微信方式进行相关通知的送达，在短信、微信发送成功后即视为完成送达。<br>
        &nbsp;（二）甲乙双方在本合同中书写的地址即为本合同下任何书面通知的有效送达地址，若因接收方拒收或地址错误等情况致使无法送达的，均以付邮日（以邮戳为准）后3日即视为通知方已依本合同给予书面通知。若任何一方联络地址变更的，应及时通知对方。
        <br><br>
        <b>&nbsp;&nbsp; 第十三条  其他</b> <br>
            <span v-if="owner.farenzhengjian=='s'">
        （一）本合同签订当日，甲方向丙方支付居间服务费：<u>{{ toDecimal(addDate.yongjin)?toDecimal(addDate.yongjin):'__________' }}</u>元。<br>
            </span>
        （{{msg04}}）
        本合同经甲乙双方签字或盖章后生效。本合同（及附件）一式{{msg03}}方各持一份。<br>
        （{{msg05}}）
       本合同生效后，各方对合同内容的变更或补充应采取书面形式，作为本合同的附件。甲方应签署附件《不动产授权委托书》，该委托书与本合同具有同等的法律效力。<br><br>
    </p>
        <p v-if="historyOptimize">
            <b>&nbsp;&nbsp;第十四条  补充条款</b> <br>
            &nbsp; 以下条款内容与本合同其它各条款具备同等法律效力,若补充条款与本合同不一致或发生冲突时，应以补充条款为准。<br>
            <u>{{yingyezhizhao}}</u>
            <br>

            <input v-if="yingyezhizhao==null||yingyezhizhao==''" type="text" name="" disabled style="width:600px;" value="以下空白">
            <br><br>
            <b> 业主方（甲方）：<input type="text" name="" style="width:265px;font-size:10px" value="">&nbsp;&nbsp;<font style="margin-left: 150px;">管理方（乙方）：</font> <input type="text" name="" style="width:119px;font-size:10px" value=""></b>　<br>
            <b>委托代理人：<input type="text" name="" style="width:305px;font-size:10px" value=""></b><br>
            联系地址：<input type="text" name="" style="width:320px;font-size:10px" value="">&nbsp;&nbsp;<font style="margin-left: 150px;">联系地址：</font><input type="text" name="" style="width:320px" value="">
            <br>联系方式：<input type="text" name="" style="width:320px;" disabled value="">&nbsp;&nbsp;<font style="margin-left: 150px;">联系方式：</font><input type="text" name="" style="width:320px;font-size:10px" value=""><br>
            <font>_______年____月____日</font>
            <font style="margin-left: 370px" >_______年____月____日</font><br>
            <br>
            <P v-if="owner.farenzhengjian=='s'">
                <b> 居间方（丙方）：</b><u>北京华亮房地产经纪有限公司</u>
                <br>联系地址：<input type="text" name="" style="width:315px;font-size:10px" value="">
                <br>联系方式：<input type="text" name="" style="width:315px;font-size:10px" value=""><br>
                <font>_______年____月____日</font>
            </P>
        </p>
        <div v-if="historyOptimize">
            <h3>补充协议：</h3>
            <history-optimize ></history-optimize>
        </div>

</div>
</template>
<style>
    .whole{
            margin: auto;
            top:0;
            right: 0;
            left:0;
            bottom: 0;
            width: 94%;
            height: 20%;
        }
        .tc{text-align:center;}
    .whole h1{
            font-size:30px;
        }
    .whole span {
            display: block;}
        .f22{
            font-size: 14px;
        }
    .whole  p{
        font-size: 14px; text-align:left;
            line-height: 2;}
        input{border: none;border-bottom: 1px solid#333333;outline: none; font-size:20px!important;text-align:center}
    .whole u{
            font-size:14px!important;
        }
    .whole input[disabled]{
            background-color:white;
        }
</style>
<script>
    import {getPurchaseContractInfo} from '../../api/api';
    import HistoryOptimize from './HistoryOptimize.vue';
    import DumpContract from './Dump20170406_pub.vue';

    export default{
        components:{
            HistoryOptimize,DumpContract
        },
        data(){
            return {
                msg01:'、丙三',
                msg02:'丙方提供居间服务等事宜，',
                msg03:'三份，甲、乙、丙',
                msg04:'二',
                msg05:'三',
                beianqixian:'',
                free_month:'',
                free_day:'',
                historyOptimize:false,
                dumpShow:false,
                property:{
                    officeList: [{
                        omcId:null,
                        loupanOmcId:null,
                        loudongOmcId:null,
                        loupanName:null,
                        loudongName:null,
                        fanghao:null,
                        weizhi: null,
                        chanquanzhenghao: null,
                        jianzhumianji: null,
                        qianyuemianji: null,
                        leixing: null,
                        hetongid:null,
                    }],
                },
                owner:{
                    chengzufang:'华溯商贸',
                    jujianfang:'',
                    yezhuleixing:1,
                    farenzhengjian:'',
                    //产权人
                    chanquanrenList:[
                        {
                            faren:'',
                            name:'',
                            zhengjian:'',
                            tel:'',
                            sex:1,
                            hetongid:null,
                        },
                    ],
                    //收款人
                    shoukuanren:'',
                    zhanghao:'',
                    kaihuhang:'',
                    //代理人
                    dailirenName:'',
                    dailirenTel:'',
                    dailirenSex:1,
                    dailirenId:'',
                    //签约人
                    qianyuerenName:'',
                    qianyuerenTel:'',
                    qianyuerenSex:1,
                    qianyuerenId:'',
                },
                addDate: {
                    startdate:'',//租期开始时间
                    enddate:'',//租期结束时间
                    shoufangdate: '',//收房日期
                    qianyuedate: '',//签约日期
                    mianzufangshi: [],//免租方式
                    mianzuqiList: [{
                        startdate:'',//免租开始
                        enddate:'',//免租结束
                        mianzufangshi:'',
                    }],
                    fukuanFangshiList:[{
                        startdate:'',//开始
                        enddate:'',//结束
                        yajinyue:'',
                        zujinyue:'',
                    }],
                    yajin:'',//押金
                    zongyingfuzujin:'',//总租金
                    yongjin:'',//佣金
                    tiqianfukuantian:'',//提前付款天数
                    yajinfukuanri:'',//押金付款日
                    shouqifukuanri:'',//首期租金付款日
                    erqifukuanri:'',//二期付款
                    sanqifukuanri:'',//三期付款
                    buchongtiaokuan:'',//补充条款
                    zujinList:[
                        {
                            startdate:'',
                            enddate:'',
                            yuezujin:'',
                            price:'',
                            dizengfangshi:'',
                            dizengliang:'',
                        },
                    ],
                    checkList: []
                },
                nian:null,
                yue:null,
                ri:null,
                yingyezhizhao:null,
            }
        },
        methods:{
            toDecimal(x) {
                var f = parseFloat(x);
                if (isNaN(f)) {
                    return false;
                }
                var f = Math.round(x * 100) / 100;
                var s = f.toString();
                var rs = s.indexOf('.');
                if (rs < 0) {
                    rs = s.length;
                    s += '.';
                }
                while (s.length <= rs + 2) {
                    s += '0';
                }
                return s;
            },
            intToChinese( str ) {
                str = str+'';
                var len = str.length-1;
                var idxs = ['','十','百','千','万','十','百','千','亿','十','百','千','万','十','百','千','亿'];
                var num = ['零','壹','贰','叁','肆','伍','陆','柒','捌','玖'];
                return str.replace(/([1-9]|0+)/g,function( $, $1, idx, full) {
                    var pos = 0;
                    if( $1[0] != '0' ){
                        pos = len-idx;
                        if( idx == 0 && $1[0] == 1 && idxs[len-idx] == '十'){
                            return idxs[len-idx];
                        }
                        return num[$1[0]] + idxs[len-idx];
                    } else {
                        var left = len - idx;
                        var right = len - idx + $1.length;
                        if( Math.floor(right/4) - Math.floor(left/4) > 0 ){
                            pos = left - left%4;
                        }
                        if( pos ){
                            return idxs[pos] + num[$1[0]];
                        } else if( idx + $1.length >= len ){
                            return '';
                        }else {
                            return num[$1[0]]
                        }
                    }
                });
            },
            daxie(money) {
                if(money==null){
                    return '';
                }
                //汉字的数字
                var cnNums = new Array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
                //基本单位
                var cnIntRadice = new Array('', '拾', '佰', '仟');
                //对应整数部分扩展单位
                var cnIntUnits = new Array('', '万', '亿', '兆');
                //对应小数部分单位
                var cnDecUnits = new Array('角', '分', '毫', '厘');
                //整数金额时后面跟的字符
                var cnInteger = '整';
                //整型完以后的单位
                var cnIntLast = '元';
                //最大处理的数字
                var maxNum = 999999999999999.9999;
                //金额整数部分
                var integerNum;
                //金额小数部分
                var decimalNum;
                //输出的中文金额字符串
                var chineseStr = '';
                //分离金额后用的数组，预定义
                var parts;
                if (money == '') { return ''; }
                money = parseFloat(money);
                if (money >= maxNum) {
                    //超出最大处理数字
                    return '';
                }
                if (money == 0) {
                    chineseStr = cnNums[0] + cnIntLast + cnInteger;
                    return chineseStr;
                }
                //转换为字符串
                money = money.toString();
                if (money.indexOf('.') == -1) {
                    integerNum = money;
                    decimalNum = '';
                } else {
                    parts = money.split('.');
                    integerNum = parts[0];
                    decimalNum = parts[1].substr(0, 4);
                }
                //获取整型部分转换
                if (parseInt(integerNum, 10) > 0) {
                    var zeroCount = 0;
                    var IntLen = integerNum.length;
                    for (var i = 0; i < IntLen; i++) {
                        var n = integerNum.substr(i, 1);
                        var p = IntLen - i - 1;
                        var q = p / 4;
                        var m = p % 4;
                        if (n == '0') {
                            zeroCount++;
                        } else {
                            if (zeroCount > 0) {
                                chineseStr += cnNums[0];
                            }
                            //归零
                            zeroCount = 0;
                            chineseStr += cnNums[parseInt(n)] + cnIntRadice[m];
                        }
                        if (m == 0 && zeroCount < 4) {
                            chineseStr += cnIntUnits[q];
                        }
                    }
                    chineseStr += cnIntLast;
                }
                //小数部分
                if (decimalNum != '') {
                    var decLen = decimalNum.length;
                    for (var i = 0; i < decLen; i++) {
                        var n = decimalNum.substr(i, 1);
                        if (n != '0') {
                            chineseStr += cnNums[Number(n)] + cnDecUnits[i];
                        }
                    }
                }
                if (chineseStr == '') {
                    chineseStr += cnNums[0] + cnIntLast + cnInteger;
                } else if (decimalNum == '') {
                    chineseStr += cnInteger;
                }
                return chineseStr;
            },
            daxie2(number){
                let arr = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];
            },
            year(riqi){
                if(riqi!=null&&riqi!=''){
                    return new Date(riqi).getFullYear();
                }else{
                    return '';
                }
            },
            month(riqi){
                if(riqi!=null&&riqi!=''){
                    if(new Date(riqi).getMonth()+1 <10 ){
                        return '0'+(new Date(riqi).getMonth()+1);
                    }else{
                        return new Date(riqi).getMonth()+1
                    }
                }else{
                    return '';
                }
            },
            day(riqi){
                if(riqi!=null&&riqi!=''){
                    if(new Date(riqi).getDate()+1 <10 ){
                        return '0'+(new Date(riqi).getDate());
                    }else{
                        return new Date(riqi).getDate()
                    }
                }else{
                    return '';
                }

            },
            //根据url得到的合同ID，来获取数据
            getPurchaseContract(id){
                getPurchaseContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //把数据分别赋值给三个组件的变量
                        this.fuzhi(res);
                    }else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            fuzhi(res){
                this.id = res.data.data.id;
                this.property.officeList = res.data.data.officeList;
                if(res.data.data.chanquanrenList.length>0){
                    this.owner.chanquanrenList = res.data.data.chanquanrenList;
                }
                this.owner.chengzufang = res.data.data.chengzufang;
                this.owner.jujianfang = res.data.data.jujianfang;
                this.owner.yezhuleixing = res.data.data.yezhuleixing;
                this.owner.farenzhengjian = res.data.data.farenzhengjian;
                if(this.owner.farenzhengjian=='l'){
                    this.msg01='两',
                        this.msg02='',
                        this.msg03='贰份，甲、乙',
                        this.msg04='一',
                        this.msg05='二'
                }
                this.owner.shoukuanren = res.data.data.shoukuanren;
                this.owner.kaihuhang = res.data.data.kaihuhang;
                this.owner.zhanghao = res.data.data.zhanghao;
                this.owner.dailirenTel = res.data.data.dailirenTel;
                this.owner.dailirenSex = res.data.data.dailirenSex;
                this.owner.dailirenId = res.data.data.dailirenId;
                this.owner.dailirenName = res.data.data.dailirenName;
                this.owner.qianyuerenName = res.data.data.qianyuerenName;
                this.owner.qianyuerenTel = res.data.data.qianyuerenTel;
                this.owner.qianyuerenSex = res.data.data.qianyuerenSex;
                this.owner.qianyuerenId = res.data.data.qianyuerenId;

                this.addDate.startdate = res.data.data.startdate;
                this.addDate.enddate = res.data.data.enddate;
                this.addDate.startdate = res.data.data.startdate;
                this.addDate.shoufangdate = res.data.data.shoufangdate;
                this.addDate.qianyuedate = res.data.data.qianyuedate;
                this.addDate.mianzufangshi = res.data.data.mianzufangshi;
                this.addDate.mianzuqiList = res.data.data.mianzuqiList;
                this.addDate.fukuanFangshiList = res.data.data.fukuanFangshiList;
                this.addDate.fukuanFangshiList.sort(function(a,b){
                    return a.startdate-b.startdate})
                this.addDate.yajin = res.data.data.yajin;
                this.addDate.zongyingfuzujin = res.data.data.zongyingfuzujin;
                this.addDate.yongjin = res.data.data.yongjin;
                this.addDate.tiqianfukuantian = res.data.data.tiqianfukuantian;
                this.addDate.yajinfukuanri = res.data.data.yajinfukuanri;
                this.addDate.shouqifukuanri = res.data.data.shouqifukuanri;
                this.addDate.erqifukuanri = res.data.data.erqifukuanri;
                this.addDate.sanqifukuanri = res.data.data.sanqifukuanri;
                this.addDate.buchongtiaokuan = res.data.data.buchongtiaokuan;
                this.addDate.zujinList = res.data.data.zujinList;
                this.addDate.zujinList.sort(function(a,b){
                    return a.startdate-b.startdate})
                this.addDate.yanqizujin = res.data.data.yanqizujin;
                this.addDate.jiafangfeiyong = res.data.data.jiafangfeiyong;
                this.nian = res.data.data.nian;
                this.yue = res.data.data.yue;
                this.ri = res.data.data.ri;
                this.yingyezhizhao = res.data.data.yingyezhizhao;
                this.beianqixian = res.data.data.beianqixian;
                this.free_month = res.data.data.free_month;
                this.free_day = res.data.data.free_day;

                var lists = this.addDate.jiafangfeiyong;
                var str ='';
                lists.forEach(function(item,index){
                    str += item.substr(0, item.indexOf('）')+1);
                    if(index<lists.length-1){
                        str +='、';
                    }
                });
                this.addDate.jiafangfeiyong = str;
                this.addDate.checkList = res.data.data.checkList;
                //给条款的每一条数据都添加一个属性字段show
                for (let x in res.data.data.tiaoList){
                    res.data.data.tiaoList[x].show = false;
                    for (let y in res.data.data.tiaoList[x].kuanList){
                        res.data.data.tiaoList[x].kuanList[y].show = false;
                        for (let z in res.data.data.tiaoList[x].kuanList[y].xiangList){
                            res.data.data.tiaoList[x].kuanList[y].xiangList[z].show = false;
                        }
                    }
                }
                this.tiaoList = res.data.data.tiaoList;
            },
        },
        mounted(){
            //获取合同的详细信息
            this.getPurchaseContract(this.$route.query);
            document.title = '华亮房产 -- 先锋地产机构、专业人、信誉人 - - - - - - - '+'合同编号:'+this.$route.query.bianhao;
            if(this.$route.query.isdump==1){
                this.historyOptimize = false;
            }else if(this.$route.query.isdump==2) {
                this.historyOptimize = false;
            }else{
                this.historyOptimize = true;
            }
        }
    }
</script>
