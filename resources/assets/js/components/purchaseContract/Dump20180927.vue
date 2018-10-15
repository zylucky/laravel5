<template>
    <div class="whole">
        <h2 class="tc">房屋资产管理服务合同</h2>
        <p>业主方（甲方）：<input type="text" style="width: 450px" disabled value=''/></p>
        <!--<p>管理方（乙方）：<input type="text" style="width: 450px" disabled v-model="guanlifang"/></p>-->
        <p>管理方（乙方）：<input type="text" style="width: 450px" disabled /></p>
        <p v-if="owner.farenzhengjian=='s'">居间方（丙方）：<input type="text" style="width: 450px" disabled v-model="owner.jujianfang"/></p>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;鉴于乙方具有行业领先的房屋资产管理服务经验，能够运用自身拥有的资源及优质的增值服务，为业主方提供完善的服务，如物业对接，装饰装修，代缴物业费、供暖费，设备、空调设施、维修检测等，提高受托管理房屋资产的使用价值，为业主方带来稳定的租金收益；同时为业主方节省大量的管理费用及时间成本。<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;现依据《中华人民共和国合同法》及有关法律、法规的规定，甲方与乙方在平等、自愿的基础上，就甲方委托乙方对下述房屋资产提供管理服务一事，达成如下约定。</p>
        <p><b>第一条  标的资产基本情况</b></p>
        <span
                v-for="(item,index) in property.officeList"
                :key="index"
        >
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（{{daxie2(2*index)}}）房屋坐落于北京市 <u>{{item.quyu?item.quyu:'_____'}}</u> 区（县）<u v-if="item.weizhi">{{item.weizhi}}</u>
            <input v-if="!item.weizhi" type="text" style="width: 200px;">，建筑面积 <input type="text" style="width:50px;" v-model="item.jianzhumianji"> 平方米,实际承租面积为 <input type="text" style="width:50px;" v-model="item.qianyuemianji" > 平方米。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;房屋用途为： <u>办公</u>  。</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（{{daxie2(index*2+1)}}）房屋权属状况：甲方持有（□ 房屋所有权证/□ 不动产权证/□ 房屋买卖合同/□ 其它房屋来源证明文件），房屋所有权证书编号：<u>{{item.chanquanzhenghao?item.chanquanzhenghao:'_________________________'}}</u>，房屋所有权人姓名或名称：
            <span style="display: inline" v-for="(item,index) in owner.chanquanrenList">
                <u>{{item.name?item.name:'__________'}}

                    <span style="display:inline;"  v-if="owner.chanquanrenList.length>1&&index<owner.chanquanrenList.length-1">/</span>
                </u>
            </span>
            ；房屋（□是 / □否） 已设定了抵押，已设定抵押的，抵押权人为：<u>{{item.diyaren?item.diyaren:'_______________'}}</u>。</p>
        </span>
        <p><b>第二条  委托管理期限</b></p>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）管理期限。甲方授权乙方代理甲方对房屋资产进行经营出租供他人使用。乙方为甲方提供《资产管理服务》（详见附件二）。委托管理期限自
            <u>&nbsp;&nbsp;{{year(addDate.startdate)}}&nbsp;&nbsp;</u>年
            <u>&nbsp;&nbsp;{{month(addDate.startdate)}}&nbsp;&nbsp;</u>月
            <u>&nbsp;&nbsp;{{day(addDate.startdate)}}&nbsp;&nbsp;</u>日至
            <u>&nbsp;&nbsp;{{year(addDate.enddate)}}&nbsp;&nbsp;</u>年
            <u>&nbsp;&nbsp;{{month(addDate.enddate)}}&nbsp;&nbsp;</u>月
            <u>&nbsp;&nbsp;{{day(addDate.enddate)}}&nbsp;&nbsp;</u>日止。<!--共计
            <u v-if="nian">&nbsp;&nbsp;{{nian?nian:'__'}}&nbsp;&nbsp;</u><span v-if="nian" style="display: inline">年</span>
            <u v-if="yue">&nbsp;&nbsp;{{yue?yue:''}}&nbsp;&nbsp;</u><span v-if="yue" style="display: inline">月</span>
            <u v-if="ri">&nbsp;&nbsp;{{ri>1?ri:''}}&nbsp;&nbsp;</u><span v-if="ri" style="display: inline">日</span>
            <span v-if="!nian&&!yue" style="display: inline">
                ____年__月__日
                </span>
            。
            甲方应于
            <u>&nbsp;&nbsp;{{year(addDate.shoufangdate)}}&nbsp;&nbsp;</u>年
            <u>&nbsp;&nbsp;{{month(addDate.shoufangdate)}}&nbsp;&nbsp;</u>月
            <u>&nbsp;&nbsp;{{day(addDate.shoufangdate)}}&nbsp;&nbsp;</u>日前将房屋按约定条件交付给乙方。《房屋交割清单》（见附件一）经甲乙双方签章确认并将房门钥匙移交后视为将房屋交付乙方。-->
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）房屋交付。甲方应于
            <u>&nbsp;&nbsp;{{year(addDate.shoufangdate)}}&nbsp;&nbsp;</u>年
            <u>&nbsp;&nbsp;{{month(addDate.shoufangdate)}}&nbsp;&nbsp;</u>月
            <u>&nbsp;&nbsp;{{day(addDate.shoufangdate)}}&nbsp;&nbsp;</u>日前将房屋按约定条件交付给乙方。《房屋交割清单》（见附件三）经甲乙双方签章确认并将房门钥匙移交后视为将房屋交付乙方。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）招商装修期：资产管理期限内，甲方承诺给予乙方 {{free_month>0?free_month:'__'}}个月{{free_day?free_day+'日':''}}的招商装修期，即自
            <span v-for="(item,index) in addDate.mianzuqiList" style="display: inline;">
                <u>&nbsp;&nbsp;{{year(item.startdate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.startdate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.startdate)}}&nbsp;&nbsp;</u>日至
                <u>&nbsp;&nbsp;{{year(item.enddate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.enddate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.enddate)}}&nbsp;&nbsp;</u>止；
            </span>
            招商装修期内，甲方不向乙方收取任何费用，以便于乙方寻找潜在实际使用人、协商洽谈、装饰装修、办理入住等事宜；招商装修期内的物业管理费、供暖费及制冷费由甲方承担。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（四）管理期满仍有实际使用人使用该房屋，乙方应及时通知甲方，本合同管理期限自动顺延至实际使用人与乙方签署的房屋租赁合同期满为止。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（五）管理期满或本合同解除后，甲方有权收回房屋，乙方应从实际使用人处收回房屋，并代理甲方办理相关手续。甲乙双方应对房屋和附属物品、设备设施及水电使用等情况进行验收，结清各自应当承担的费用。
        </p>
        <p><b>
            第三条  标的资产的固定收益及保证金
        </b></p>
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）固定收益支付标准：经双方协商一致，乙方在受托管理期间，根据固定收益与甲方进行结算，具体结算金额如下：
        <span v-for="(item,index) in addDate.zujinList">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                自<u>&nbsp;&nbsp;{{year(item.startdate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.startdate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.startdate)}}&nbsp;&nbsp;</u>日至
                <u>&nbsp;&nbsp;{{year(item.enddate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.enddate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.enddate)}}&nbsp;&nbsp;</u>日止，固定收益为人民币（大写）<u>&nbsp;&nbsp;{{daxie(item.yuezujin)}}&nbsp;&nbsp;</u> /月（￥：<u>&nbsp;&nbsp;{{toDecimal(item.yuezujin)?toDecimal(item.yuezujin):'___'}}&nbsp;&nbsp;</u>元/月）；
            <br>
        </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如有延长期，延长期固定收益为人民币（大写）<u>&nbsp;&nbsp;{{daxie(addDate.yanqizujin)}}&nbsp;&nbsp;</u> 元/月（￥：<u>&nbsp;&nbsp;{{toDecimal(addDate.yanqizujin)?toDecimal(addDate.yanqizujin):'____'}}&nbsp;&nbsp;</u>元/月）。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）支付方式：<br>
            <span v-for="(item,index) in addDate.fukuanFangshiList"
                  :key="index"
                  style="display: inline;"
            >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                自<u>&nbsp;&nbsp;{{year(item.startdate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.startdate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.startdate)}}&nbsp;&nbsp;</u>日至
                <u>&nbsp;&nbsp;{{year(item.enddate)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(item.enddate)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(item.enddate)}}&nbsp;&nbsp;</u>日,每 <u>{{(item.zujinyue?daxie2(item.zujinyue-1):'_____')}}</u> 月支付一次。
                <br>
            </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;固定收益中包含物业管理费、供暖费及制冷费。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）支付时间：首期固定收益支付时间为
            <u>&nbsp;&nbsp;{{year(addDate.shouqifukuanri)}}&nbsp;&nbsp;</u>年
            <u>&nbsp;&nbsp;{{month(addDate.shouqifukuanri)}}&nbsp;&nbsp;</u>月
            <u>&nbsp;&nbsp;{{day(addDate.shouqifukuanri)}}&nbsp;&nbsp;</u>日前，其余每期在实际应付款月（减除招商期后）开始管理之日的前 <u>&nbsp;&nbsp;{{addDate.tiqianfukuantian}}&nbsp;</u>天进行支付，即第二期支付时间为
            <u>&nbsp;&nbsp;{{year(addDate.erqifukuanri)}}&nbsp;&nbsp;</u>年
            <u>&nbsp;&nbsp;{{month(addDate.erqifukuanri)}}&nbsp;&nbsp;</u>月
            <u>&nbsp;&nbsp;{{day(addDate.erqifukuanri)}}&nbsp;&nbsp;</u>日，
            <span style ="display: inline" v-if="addDate.sanqifukuanri">第三期支付时间为
                <u>&nbsp;&nbsp;{{year(addDate.sanqifukuanri)}}&nbsp;&nbsp;</u>年
                <u>&nbsp;&nbsp;{{month(addDate.sanqifukuanri)}}&nbsp;&nbsp;</u>月
                <u>&nbsp;&nbsp;{{day(addDate.sanqifukuanri)}}&nbsp;&nbsp;</u>日,
                </span>管理期内每期支付时间以此类推。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（四）保证金：人民币（大写）
            <u>&nbsp;&nbsp;{{daxie(addDate.yajin)?daxie(addDate.yajin):'______'}}&nbsp;&nbsp;</u> （￥：
            <u>&nbsp;&nbsp;{{(toDecimal(addDate.yajin)?toDecimal(addDate.yajin):'_______')}}&nbsp;&nbsp;</u> 元），乙方在甲乙双方签署本合同当日向甲方支付，如甲方提供的房屋所有权证复印件和身份证复印件不全，则乙方仅支付甲方百分之五十的保证金，剩余百分之五十的保证金于甲方补齐房屋所有权证复印件及身份证复印件后支付。管理期满或合同解除后，保证金除抵扣应由乙方承担的费用，剩余部分应如数返还给乙方。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（五）支付账户：<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;甲方指定收款账户为：
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名&nbsp;&nbsp;&nbsp;称：  <input type="text" style="width:500px;text-align:left" v-model="owner.shoukuanren">
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开户行： <input type="text" style="width:500px;text-align:left" v-model="owner.kaihuhang">
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;账&nbsp;&nbsp;&nbsp;号：  <input type="text" style="width:500px;text-align:left" v-model="owner.zhanghao">
        </p>
        <p><b>第四条  资产管理服务费</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;乙方运营标的资产所实际收取的金额为实际收益。实际收益高于固定收益的差额为资产管理服务费。甲、乙双方一致同意，乙方按照风险自担的方式收取资产管理服务费。即乙方对房屋进行代理出租及房屋管理而取得的收入中，超出向甲方支付固定收益的溢价部分，将作为乙方的资产管理服务费，由乙方直接收取；如未产生溢价的，甲方亦不向乙方支付任何服务费用，该风险由乙方自行承担。</p>
        <p><b>第五条  相关费用的承担方式</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）管理期限内的下列费用中， <u>{{addDate.jiafangfeiyong?addDate.jiafangfeiyong:'_____________'}}</u>  由甲方承担， 其他费用 由乙方（或实际使用人）承担：(1)供暖费 (2)制冷费 (3)物业管理费 (4)水费 (5)电费 (6)燃气费 (7)电话费 (8)电视收视费 (9)上网费 (10)卫生费 (11)车位费 （12）其他
            <input type="text" style="width:100px;">。同时，为了方便房屋实际使用人的后续使用，（3）物业费由乙方代甲方向物业公司缴纳，并在支付给甲方的每期固定收益中予以扣除。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）乙方仅承担本合同列明应由乙方承担的费用。如乙方垫付了应由甲方承担的费用，甲方应根据乙方出示的相关缴费凭据向乙方返还相应费用或由乙方直接从下一次支付的固定收益中扣除。
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）在管理期内，甲方应协助实际使用人开具房屋租金发票（增值税普通发票或增值税专用发票）；如根据税收部门规定，需要甲方到场配合或提供房屋权属证明等相关材料办理税务发票事宜时，甲方应出面配合或提供。若实际使用人需要租金发票，乙方可代为办理，但乙方不承担相关税费，具体费用由实际使用人承担。</p>
        <p><b>第六条  标的资产的装修及维护</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）标的资产的装修
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;甲方应保证房屋的建筑结构和设备设施符合建筑、消防、治安、卫生、电路、防水等方面的安全条件，不得危及人身安全；乙方应遵守国家、北京市的法律法规规定以及房屋所在小区的物业管理公约。管理期间内，甲方同意乙方对标的资产进行必要的装修及改造，但不得破坏房屋的承重结构。同时，甲方将配合乙方办理装修改造所需的相应手续、审批、许可或文件。甲方认可并接受乙方对标的资产装修改造的标准和规格，不得以不接受该标准和规格为由，单方面解除合同。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理期间，乙方会为标的资产购置新的设备、设施或用具（“新配置设施”）， 配置设施的所有权为乙方所有。在管理期间，若非乙方原因造成新配置设施的毁损，乙方有权从相应责任人处获得相应赔偿。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）标的资产的维护
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;甲方的维修责任：对于该房屋的主要结构、固定管道线路及固定设施（包括制热、制冷、排风、上下水、电路及燃气等设施）因自然属性或合理使用而导致的损耗，由甲方承担维修责任。发生上述维修情形后，乙方应及时通知甲方修复；甲方应在接到乙方通知后的3日内进行维修（详见附件四《维修项目列表》）。逾期不维修的，乙方可代为维修，费用由甲方承担，乙方可直接从下一次支付的固定收益中扣除维修费用及由此给乙方造成的经济损失。乙方的维修责任：因乙方管理不当或实际使用人的不合理使用，致使该房屋的主要结构、固定管道线路及固定设施发生损坏或故障的，乙方应负责维修或承担赔偿责任。因实际使用人使用不当造成的损坏，应依照“谁损坏，谁负责”的原则，由实际使用人承担维修责任，乙方可代为处理，事后向实际使用人追偿。
        </p>
        <p><b>第七条  甲方权利义务
        </b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）甲方授权乙方代表甲方运营出租标的资产， 签署与资产管理有关的合同（包括但不限于房屋租赁合同等）； 甲方应配合乙方处理管理期间发生的纠纷（包括但不限于与使用标的资产使用人开展洽商和/或追究其违约、侵权责任或参与相关的诉讼），非因乙方或资产使用人原因而使标的资产遭受来自第三方的侵害时所发生的纠纷由甲方自行处理。甲方有权按照本合同约定收取固定的收益，并在管理期限届满或合同解除时按照约定收回房屋。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）甲方应按约定日期将房屋及其设施设备在整洁完好的状态下交给乙方,并及时清理与《房屋验收清单》（见附件三）无关的物件。甲方承担房屋在交付乙方前发生的一切费用，并予以结清，同时详细填写在《房屋验收清单》上。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）甲方应向乙方出示其对房屋拥有合法所有权的证明文件,包括但不限于房屋产权证、契税发票、购房合同及身份证的原件，乙方有权保留其复印件，同时甲方应签署《授权委托书》（见附件五）。甲方承诺该房屋权属无瑕疵、无债务纠纷，没有妨碍正常出租使用该房屋的抵押，不存在任何形式的查封、拍卖等权利限制，房屋设施符合出租条件。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（四）出租房屋为办公、商业用途的，甲方应配合乙方办理经营资产所需的一切手续、审批、许可或文件，包括但不限于协助实际使用人办理营业证照、工商注册、税务报到等事宜。根据本地工商部门要求，甲方应于签署本合同后 <u>{{beianqixian?beianqixian:'____'}}</u> 日内持房屋所有权证或不动产权证及身份证原件到工商局进行备案；如甲方未能于上述日期进行备案，乙方有权不支付固定收益，直至甲方办理备案登记并能够进行工商注册之日止。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（五）甲方全权委托乙方对此房屋进行推广招商、商业运营、房屋装修改造（主体结构除外），对实际使用人进行管理，甲方应积极配合乙方对上述事项相关手续的办理。</p>
        <p><b>第八条  乙方权利义务</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）甲方授权乙方在管理期限内，对标的资产进行代理出租并提供资产管理服务，授权乙方代理甲方与实际使用人签署《房屋租赁合同》并代收租金和押金等费用；对实际使用人使用房屋进行监督和管理，同时收取相应的管理服务费。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）乙方应积极完成甲方委托的管理事项，依法从事招租招商工作，利用自身的信息资源、媒体广告寻找潜在的承租客户，对该房屋进行推介；乙方可运用自身资源有偿或无偿为实际使用人提供装饰装修、工商代理、财务、法律等增值服务，尽可能提高资产的商业使用价值，吸引商户入驻，以利于甲方最终能获得稳定的固定收益。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）在管理期限内，如乙方对该房屋进行装饰装修的，需符合国家相关规定，乙方可以对房屋进行清洁粉刷、装饰装修及增加室内设施设备。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（四）在该房屋管理期满后，若乙方未有严重违约行为，在同等价格条件下，乙方享有优先接受委托管理该房屋的权利。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（五）在管理期限内，甲方转让该房屋，应提前60日通知乙方，乙方在同等价格条件下享有优先购买的权利；甲方转让该房屋的，甲方承诺本《房屋资产管理服务合同》对受让方继续有效并具有法律约束力，甲方应与受让方对本合同进行交接。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（六）因甲方拖欠相关费用导致资产无法正常使用的，如乙方进行了垫付，甲方应根据乙方出示的相关缴费凭据向乙方返还或由乙方直接从下一次支付的固定收益中扣除。</p>
        <p><b>第九条  合同解除</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）经甲乙双方协商一致，可以解除本合同。<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）因不可抗力导致本合同无法继续履行的，本合同自行解除。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）甲方有下列情形之一的，乙方有权单方解除合同：
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、迟延交付房屋达10日的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、交付的房屋不符合法定和约定的使用条件或影响实际使用人安全、健康，或未提前说明存在重大安全隐患如漏水、漏电的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、不承担约定的维修义务，致使乙方无法正常管理或使用房屋达10日的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、甲方不配合房屋实际使用人开具增值税专用发票或增值税普通发票，以及违反本合同第七条及其他约定义务的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5、房屋如有原租户营业执照、税控机未迁出的情况，甲方应积极配合，甲方不予配合，导致乙方或实际使用人无法办理入驻的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（四）乙方有下列情形之一的，甲方有权单方解除合同：
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、不按照约定支付租金收益达10日的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、擅自拆除或破坏房屋建筑主体结构的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、利用房屋从事违法犯罪活动而损害公共利益的。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4、要求提前解除本合同的。<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（五）其他法定的合同解除情形。双方另有约定的除外。
        <p><b>第十条  违约责任</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）甲方有第九条第（三）款约定的情形之一的，应按2个月的固定收益为标准向乙方支付违约金，且乙方有权单方解除本合同；乙方有第九条第（四）款约定的情形之一的，应按2个月的固定收益为标准向甲方支付违约金，且甲方有权单方解除本合同。
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）因甲方违约致使合同解除的，甲方应补偿乙方对该房屋进行装饰装修以及添附设备所支付的费用；同时甲方应退还乙方已支付的未管理房屋期间的固定收益；若资产上有正在生效履行的《房屋租赁合同》，则甲方还应承担因本协议解除导致《房屋租赁合同》解除产生的全部违约责任，若涉及支付违约金，甲乙双方同意由乙方代为收取，由乙方负责支付给房屋实际使用人。</p>
        <p><b>第十一条  争议解决</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本合同项下发生的争议，由双方当事人协商解决；协商不成的，依法向有管辖权的人民法院起诉，或按照另行达成的仲裁条款或仲裁合同申请仲裁。</p>
        <p><b>第十二条  送达条款</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）甲乙双方一致同意，合同履行期间如需出具通知，应以书面形式（包括但不限于邮寄送达、电子邮件、手机短信、微信以及乙方向乙方在其网站中为甲方开设的业主空间发送通知等方式）做出，具体送达日期为：邮寄送达以信函发出后的第 2 个工作日为准，电子邮件以到达对方服务器时间为准，手机短信、微信及网站通知以达到对方设备时间为准。 甲方联系电话、地址、 微信、邮箱发生变动的，应及时以书面形式通知乙方，因甲方未及时通知乙方所导致的无法送达或其他损失，均由甲方自行承担。<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（二）甲乙双方在本合同中书写的地址即为本合同下任何书面通知的有效送达地址，若因接收方拒收或地址错误等情况致使无法送达的，均以付邮日（以邮戳为准）后3日即视为通知方已依本合同给予书面通知。若任何一方联络地址变更的，应及时通知对方。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（三）若由于以下原因造成付款延迟，乙方不承担责任：甲方未及时提供账户信息或账户信息发生变更未及时通知乙方、甲方产权人发生变更未及时通知乙方、银行系统原因、其他非乙方原因等。</p>
        <p><b>第十三条  其他</b></p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（一）本合同生效后，各方对合同内容的变更或补充应采取书面形式，作为本合同的附件；附件与本合同具有同等的法律效力。甲乙双方一致同意，未加盖乙方正式印鉴的任何书面承诺、口头承诺、条款变更等行为均不视为乙方行为，对双方不产生法律约束力。
            <br v-if="owner.farenzhengjian=='s'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{msg_03}} <input v-if="owner.farenzhengjian=='s'" v-model="addDate.yongjin" style="width: 50px;" ><span v-if="owner.farenzhengjian=='s'" style="display:inline;">元</span>
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（{{msg_02}}）本合同经甲乙双方签字盖章后生效。本合同附件为合同的有效组成部分，与合同正文具有同等法律效力。本合同（及附件）一式{{msg_04}}份，甲乙双方各持一份，{{msg_01}}每份具有相同法律效力。</p>
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
            <b> 居间方（丙方）：</b><u>北京华亮房地产经纪有限公司</u>
            <br>联系地址：<input type="text" name="" style="width:315px;font-size:10px" value="">
            <br>联系方式：<input type="text" name="" style="width:315px;font-size:10px" value=""><br>
            <font>_______年____月____日</font>
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
        top: 0;
        right: 0;
        left:0;
        bottom: 0;
        width: 92%;
        height: 20%;
    }
    .tc{text-align:center;}
    .whole h1{
        font-size:32px;
    }
    .whole span {
        display: block;}
    p{
        font-size: 14px; text-align:left;
        line-height: 2;}
    .whole input{border: none;border-bottom: 1px solid#333333;outline: none; font-size:14px!important;text-align:center}
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
    import DumpContract from './Dump20170719_pub.vue';

    export default{
        components:{
            HistoryOptimize,DumpContract
        },
        data(){
            return {
                msg_01:'丙方留存备案一份，',
                msg_02:'三',
                msg_03:'（二）本合同生效后，甲方向丙方支付居间服务费¥：',
                msg_04:'三',
                historyOptimize:false,
                dumpShow:false,
                beianqixian:'',
                free_month:'',
                free_day:'',
                guanlifang:'北京幼狮科技有限公司',
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
                let arr = [ '一', '二', '三', '四', '五', '六', '七', '八', '九','十','十一','十二'];
                return arr[number];
            },
            year(riqi){
                if(riqi!=null&&riqi!=''){
                    return new Date(riqi).getFullYear();
                }else{
                    return "";
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
                if(this.owner.chengzufang=='无'){
                    this.guanlifang = '';
                }
                this.owner.jujianfang = res.data.data.jujianfang;
                this.owner.yezhuleixing = res.data.data.yezhuleixing;
                this.owner.farenzhengjian = res.data.data.farenzhengjian;
                if(this.owner.farenzhengjian=='l'){
                    this.msg_01='';
                    this.msg_02='二';
                    this.msg_03='';
                    this.msg_04='两';
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
            document.title = '合同编号：'+this.$route.query.bianhao;
            //            function  hello() {
            //                window.print()
            //            }
            if(this.$route.query.isdump==1){
                this.historyOptimize = false;
                //setTimeout(hello,1000);
            }else if(this.$route.query.isdump==2) {
                this.historyOptimize = false;
            }else{
                this.historyOptimize = true;
            }
        }
    }
</script>