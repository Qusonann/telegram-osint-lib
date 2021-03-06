<?php

namespace Tests\Tests;

use MTSerialization\MTDeserializer;
use PHPUnit\Framework\TestCase;
use Tests\MTSerialization\OwnImplementation\OwnDeserializerMock;

class OwnDeserializerTest extends TestCase
{

    /**
     * @var MTDeserializer
     */
    private $deserializer;


    protected function setUp(): void
    {
        $this->deserializer = new OwnDeserializerMock();
    }

    private function deserializeIntoComparableObject($serialized)
    {
        $serialized = hex2bin($serialized);
        /** @noinspection PhpUnhandledExceptionInspection */
        $object = $this->deserializer->deserialize($serialized);
        return $object->getPrintable();
    }


    public function test_usual_msg_container_deserialization()
    {
        $data = "dcf8f1730200000001f8c122519ae95a010000001c0000000809c29eec122300539ae95a2fbba56745e18a4d7f10e48f8478eb6801fcc122519ae95a0200000014000000c5737734ec122300539ae95a1b5027dc33f4e9c4";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/usual_msg_container_deserialization');
        $this->assertEquals($got, $expected);
    }


    public function test_rpc_result_with_object_response()
    {
        $data = "016d5cf3a08d2000acaae95a4c0acdd115c4b51c01000000388402d053ddb309010000000000000015c4b51c010000001983fbf253ddb309000000000000000038405c102fcbaf9b0b373932353536373736323793140d997690d6530200000041829a0e00000000c29200005a578e4be36e2bda7690d6530200000041829a0e00000000c4920000202020ca42e3b7af4950d009";
        $got = $this->deserializeIntoComparableObject($data);

        $expected = file_get_contents(__DIR__ . '/expected_objects/rpc_result_with_object_response');
        $this->assertEquals($got, $expected);
    }


    public function test_rpc_result_with_vector_response()
    {
        $data = "016d5cf348fa3800ad20eb5a15c4b51c0300000073b877aa53ddb3090000000073b877aad92d300ba01feb5a73b877aa2d205b1e54125a5a";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/rpc_result_with_vector_response');
        $this->assertEquals($got, $expected);
    }


    public function test_msg_container_with_msgs_acks_message_with_vector_of_long_response()
    {
        $data = "dcf8f17302000000014c17d20f4dec5a010000001c0000000809c29e8cd90800114dec5a1e405c321851805f779f31365a02bcc0010c18d20f4dec5a020000001400000059b4d66215c4b51c010000008cd90800114dec5a";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/msg_container_with_msgs_acks_message_with_vector_of_long_response');
        $this->assertEquals($got, $expected);
    }


    public function test_get_config()
    {
        $data = "016d5cf3880a2a00895dec5a05592d23885dec5a379779bc0200000015c4b51c050000003ca4c22e01000000000000000e3134392e3135342e3137352e353000bb0100003ca4c22e02000000000000000e3134392e3135342e3136372e353000bb0100003ca4c22e03000000000000000f3134392e3135342e3137352e313030bb0100003ca4c22e04000000000000000e3134392e3135342e3136372e393200bb0100003ca4c22e05000000000000000d39312e3130382e35362e3135390000bb010000c8000000";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/get_config');
        $this->assertEquals($got, $expected);
    }


    public function test_gzipped_content()
    {
        $data = "016d5cf384cd2d001174ec5aa1cf7230c81f8b0800000000000003f3e13a7b51f4c85619260606068b16a60bb1654c5c8c0c1000e2ff7758a604e3c3d44936fffe0452071566f825d9e4d52f9820c76d6e69646669616e6c6c683659847766d9846bc120f53fc49ab540eabef03032c4b24e0db9f8d4530d5dee1b50ee42f041f31b717f66db17f43078e5bc8902d903b21f66cf3cb1dfa95ed7e6fc01d9636a666160686a6c8a6ccf74e9b57c2075d2331918deeebc6a265b945e872e270b94eb74bdbea2e9e22a59903d9273ee4601000d36062104010000000000";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/gzipped_content');
        $this->assertEquals($got, $expected);
    }


    public function test_ack_msgs()
    {
        $data = "59b4d66215c4b51c01000000013cf6db18b5ed5a";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/ack_msgs');
        $this->assertEquals($got, $expected);
    }


    public function test_foreign_user()
    {
        $data = "a1cf7230fed804001f8b08000000000000035d557b5054551c3ecb4314160545126409616c5213ef3eeedebd0521b2d42c10b84004b8480b6cb8082cb004a1650aa82c110a0cea02390eafc1144107e5b1bc6ca8c93f880b91128e4d25a8bc1a3386d180ec9cbbdcbadc3bb373f73bdf39e7fb7ebff33bbfbb77dfb5eccd0337dd360100aa8aeb9551837fd87ce8b673e4f936c92684472adbd6b2715c8e852d1bffbc1bb363e38985f855b8a22961031b4f1e78e2c8c68d45311bd9583fe0e0c4c6fbe78d5bd8f86ed0391736beda6f7265e39bcdf7ddd8b83f3451c0c6a6d1ba55386906735fe5ef5492071bbfdcdbe8c9c6cf6477fec34cdebefade291ce5cd2648a7576bd3356b951fabb334fa3435e44a2ebde3da22775eaa70b237e69cbd1bc18363db7a1eef812f6069cb03927ae9829fd6b297cb59436eca2fb3b5c1fd51a15f460998f49a8d7129587c86ce03ac3ca67687f3675efd54cc27a5521cc344329cc47138ce6859c1ffef875f7641734fdfb004a6febeceeb176b9bb89c01724193848427ff3619691d24a763514ce8acad14a929280e7ec42175864e7f285d7b5897037179f99476fd11b7c78c96051c7bee5cb013ed37cfe78138ebcac8e149c56b5c6e017254c46d62ece05235d2925e9fa3b5501d59f8ebc1bac0f4c4acbc8c6c711200b967a387fff28a5c646b34ba67daa37d7c5eb700fe46a7a90949b79ccbbd0db91345fae296e5b6163a9e91b958943b549b4cee425a83c9c8925fefd9e3b8504812307d424c8c01f05b9763185ae369b78bce37aa5f668d8f6f4ece3f6301cb7c31291611129184148909f0ff9a1d6766e958508ddb52cd9489eaa07aa856e0405551bdc3c7874ba9ae9511002e9ccc37faecb8a062c7d62f0ba6fd971d7104e34d6f54856cf17bcae52a2057933d58a9a8535d419ac61fcdb1a17bc4f87c38a6f4574d9795d27521c3481213e104a72ee6675fd0671f176309be9b99f00a5e13f290cbc543ee16a5dc1ef5e4e849a4d55a62d6427794d1724f0ce5bd6788ff8c2f2185042125a53099229616f21eedd9bc1ecd9df81b803d85364675c3f8152ef708725d7dc97fa6dd686b475a8daa595a0bdd7f46cbf0fbe17adfb05f52e8fc6384881012329295ff4e5d29bd06f508664d71f40fdeb7026a73f9225c480a4909866322b63f14af6748992b9afb968d05b8b33830e33a78699ecbf942aef1627b7593a6a81669f97e60f687fa0fa325167aa4e95c14a97c24448a49420a6b84e52ff56a470caa0fd4a3ace55a4db2cebc4e1e1e50492c05d8b13d0dc80df4becbed3cd0418a63cfed5699b8dc4bc855189c7b4ff9ab8bd1fec1df98cf07f53cc6d327012fca7d2f7b2bf82421c4318948844ba53296271ceba16b16f5459b7d6abd5eaf4db3f14f4dd1256469a951d5e937bd0d7ab62fbe5d29ad1d5b0dc06882c750d4ed6b422ea7825c6683ee7330dc9d41d7e8c607b406eab56b94b99aacec3c6015aad1ebe1dceeb6cd07bed0fa5b233f8afdd43afafec01e6c19a4ce833fadb06f5170f4a33629e3b77f2546d49799181777d9beab9c4e37d911240c4f86097131ceaebff35bcd35b6d508c05ce74f524156f2312e27809c21f05e53fef0d702a4e352f380d641fd9ed1192a7cfa65daf6ba023e2923c53282946130a19c5acadf60cec1b1792b503324b86f28cc23b8dc71c88505fa64bd424d2422ad134373b1e85b82b871789fa5f043f02f5a39725898070000";
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/foreign_user');
        $this->assertEquals($got, $expected);
    }


    public function test_updates()
    {
        $data = '4042ae7415c4b51c010000009a8aa451d92d300b601c2ad2471f80a7b575729915c4b51c01000000b0cee822d92d300b0241730009456e6372797074336400006216d43559a824f00b373931363939303438363393140d997690d65302000000a61e710d000000003c280200419914e9e434bc447690d65302000000a61e710d000000003e2802008188738aaffdb4af3f708c00cecb3c5b15c4b51c00000000e5d93c5b22000000';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/updates');
        $this->assertEquals($got, $expected);
    }


    public function test_update_user_new_photo()
    {
        $data = 'c1ded47807a68bbbeb32140993140d997690d6530400000076059f1a00000000ed2d0100ec837bedb9326ecc7690d6530400000076059f1a00000000ef2d01008a6a83603a4a8d51d0a6405b';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/update_on_new_photo');
        $this->assertEquals($got, $expected);
    }


    public function test_update_user_new_photo_2()
    {
        $data = 'c1ded47807a68bbbc121170ce1ba114fbb98435b';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/update_on_new_photo_2');
        $this->assertEquals($got, $expected);
    }


    public function test_user_object_tg_app()
    {
        $data = '016d5cf3541625003bd1405ba1cf7230fe3301001f8b0800000000000003b396b9502e7a64ab0c33030383450bd3854d5ae755eadf4c0cce5370f907e2ff7ab45d92f761cc627eb987d740fc3e4d09ce2337627ed545470a81f401b53120d320730e7f11d62be760600099b5ccfbbd3977428391505e626e6abca59989b985a181999991b9b921034f4ebc898189b991a551529229501f2faa34c3891b9157572e379406995336e15a3013508dff9ded7c20bbde1d6560908ce6d40b640d7c802ef7012837edcbeb7eb674fdfff6053d0cd63c0ed120378503dd04f2cf01937d1bbe791a4c1584b8c9dcc8d4c0d8c4c4c2cccc8c01e4260b735313cb344333c344a0593ca8d20c20f38a8e22cc038507d737b127863c7fe70980cd333530b33036353737303760009b976a6191626a9e6c6a08d2cf8d240d328bf9885d34003fea1af48401000000';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/tg_app/imported_contacts_response');
        $this->assertEquals($got, $expected);
    }


    public function test_update_link_tg_app()
    {
        $data = '4042ae7415c4b51c01000000c5672e9da907d117d0c202d547924f5f15c4b51c01000000c3f4132e5f080000a907d117d925d062a03cb7e30f6e616d655f363539343330313831310c6c5f3834323433343862353500000006456b6e656e67000a36353934333031383131003f708c001843435b15c4b51c00000000c453435b05000000';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/tg_app/update_link_response');
        $this->assertEquals($got, $expected);
    }


    public function test_update_contacts_reset_tg_app()
    {
        $data = 'a1cf7230fec506001f8b08000000000000035d567b700d5718df242ae1864422866a55514294f3d8ddb3ab9d263142490d53453d63efddddc8e0561209496bda543ba5a5a366bc8ad6342a98561fa294d188c74c51f518c45b1925d5a63308a22f3ddfbd7bf6eebd7fddf9e6f7dddffebeeffb9def9c9cc15be7641cd8fe441749927ea87967f6c1c201eb1a26e6b53dbe2ffef4b065a30a20feaea5772f6f5cfb6048576f7cefa794646f9c53f17d1b6fdcf7d9af53bdf1e6616da3f80fbe773ddd1bafea7e2bcd1bf7383128ea7ba706962779e34f3f1810c57f3cf061547ed5d6bd4f7be347692fb7f3c6cfb689efe48d5fcfecd1c51baf78e26a0f6f7c63e79aa8fced29f519deb879db729f379e521e1f55efe0710551fd2c589f1b2f629845673e8bfdcde903c6274912cce2504edf51035ad484d4a031cb2a603a56159d292ad1785ef2cc02840c14f063dbf6f3d8e781b3672f9626340c9c24b8608eb55fe6bdba62c8c9173a84b874aceb9aaaaa58414a884bb1100ad8cc8f03c01d0d4bc0b760a8ecf2810f82470e5ce8dfaafeb794109faa68b2ae232a53cea562cd44889a86ccffdb36028578ea86658778e6721ef0cfd8c295839e3a5a87d3c2ba549929f07119e90474993aaf92326623ced52e1a967e3c3be1f4d61adc1578ca979e1913cf73f634af69cf7fa4e2f3715265e6df0b2e9ddab133162be5d8e84b7fd5dfac3c51039a4667e4b9b5818797b42aed9755bcec5cb8ef14ab84b71611eaf4dd1fb00dc275a8a0c9e781810bcfba3d51d407fe6fa9bd7e2467d195ba30174f53a8a62084e530972a234e473413faeef3c050db665e1b7080fe388ef75a7b7320e8efb0214eaa1eba2af33efaf7602c96ceb111779b7c7f96e54e073dbd36876b7b93eb81f397dc33a5eee17779bb239e42aa4291a284f558966e10c3af598cc7ad8b82730db322ec2d270d742ddb8cbb0297e86b63220df575e8ae04a961ce81f77f2ff44f8bc55ee4d82753b35e59df986ddf1efcda35d054c035c10e48bb7b79f194fb0f5e8f68d211771e22614dd84616d3fcaa023e4f1d6395145a1505238d192565a5d38b82c2fbce5fa0e6ce9723f3849d52ae5d1db877dde92f043f5111638aa662679ec4b68846b045c25c2e0c5cfda70c71fd0afbe8c9f953fb60df89e608974c74cc1d1ae6d275ea6716b6654d703930f46d0b9f277088debc9b1ceecd88b992d4943eb9e1d0b7392763b19738b6e4f07f47c7be7d6c1ee8c99fb66ea2a80df661e6a3d67bca3bbe5116d1a368989f11eaf8cb5218a12ce0a7428f038b19802f608f4e7e3ef7c1ecb30ddd048fa6c88a8c75a23b3c1a4244b61402be4d2c9a5961945ab37c9e34a86f3baf0fb8440dd752c335dcec99203d9a9fb5b429488fc562bf71acdbedd97fcfb877e517a1096a835d6e6766649f5ab13235a249a17c0520a736d934340351d508846b7361e8d37387aadc3ec13d207d748e1dfcb9fe66988b304611d3f96c90e37b6406a84d6cd9062e0f0c5c2535b9ee19823be44acabca1bf6f58f0b8d0a56a8c276bc439d3868a89c60c8b82aec48ab2606129557c9e34e8552def1570897e6ce8b836d48f95c99294d5e6c6fe5de8ababb1d86a8e1d6ebbc5aade64f7065dafaec973bd0977d98895dfec1e742a272da20bfc27abce0c0dd3b2fc365134c70b2e2c760d70886f668fd9d10ebed9a9284eeadb6664f5eaf9ed2fc6629d39b6477e33aebfb4b1c63b3bb847b78cecb09655eee828b4f0d541282562cf689a81fd2aa68a19d6e2c25097bdb1977b7ee10ebef0477059feb5b7c6ba5c5c3a25183bfb81321b1bd4b643fdf77960e09ad527c3ed11dcdf8d8b3f3cda326de92d77d7105d87b5ebf880a8a64c0286a639bbc085c5f9050ed1873b727ea80fd59fb59316261cf9b1a8b86f552cf639c7d28f9de9d2f310390f7a9eaa8fec26783f2c7c50b7a3a272f733ae1e056145a762f73164cbd46fe80c397a040c5cd71f364e14be84b7c7f8c2736bfbe5def772c90423cdb9b74c0b1b163370c0e271ca48a3644e51f0b5f2a2c0f4e1e546d0e749177e004e514f539fe2703d89f192f247b7bc7c5a69c662351cdbb9befbb6fae2ca8ba06fdec7a9eeb981b75059d3f5552d5f5e3e1cd955bac628bf401d7f1283108ab0099e48324b8c1915338d12b1b79c54a10df8c4f75b3a2de807df6f4e8e93a63cb6fc9513bf0eef1d8bdde7d8f131f5ececd47fd684f6e82f9139c0bbec4ec338933ef6e238571b6358652a757c61326cf2ddc954e6e81170e8ad558ddc3ae14d777a52d5aa24c412dd7348553e3299397bcb8f4d6a22bf1d7a4fb49e619414961585cea348831adb6fc25d814bd4d1e95a55a8c7ffbcdd4aba95d5316951edf86eb1d87f1cbb317fd8c2fce5fb2cd0557c3c6f12bc2b01dbd698372981fffe0f08b86cc8f80b0000000000';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/tg_app/update_contacts_reset');
        $this->assertEquals($got, $expected);
    }


    public function test_sent_code_tg_app()
    {
        // dataJSON вместо help.DataJson
        // messages вместо entities
        $data = '5fabfa380e000000a2bb00c0050000001234646538343662656532643139326230646500e3d31c747800000010030a7800000000048d747d937b22636f756e747279223a225255222c226d696e5f616765223a66616c73652c227465726d735f6b6579223a225445524d535f4f465f53455256494345222c227465726d735f6c616e67223a22656e222c227465726d735f76657273696f6e223a312c227465726d735f68617368223a223764636138303663623864333837633037633737386365396566366161633034227dfe3901004279207369676e696e6720757020666f722054656c656772616d2c20796f75206167726565206e6f7420746f3a0a0a2d20557365206f7572207365727669636520746f2073656e64207370616d206f72207363616d2075736572732e0a2d2050726f6d6f74652076696f6c656e6365206f6e207075626c69636c79207669657761626c652054656c656772616d20626f74732c2067726f757073206f72206368616e6e656c732e0a2d20506f737420706f726e6f6772617068696320636f6e74656e74206f6e207075626c69636c79207669657761626c652054656c656772616d20626f74732c2067726f757073206f72206368616e6e656c732e0a0a576520726573657276652074686520726967687420746f20757064617465207468657365205465726d73206f662053657276696365206c617465722e00000015c4b51c00000000';

        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/tg_app/sent_code');
        $this->assertEquals($got, $expected);
    }


    public function test_update_new_channel_message()
    {
        $data = 'dcf8f17303000000019c01ec1ba5ac5b2000000014000000c5737734a86b35001ba5ac5b35770b7f3dc471da01e401ec1ba5ac5b21000000dc0000004042ae7415c4b51c01000000d904ba62f6a1199e00010000e90f000063d04d2832e5ddbd470e4d44eaa4ac5b37738a4815c4b51c0100000063d04d28ae1200000100000015c4b51c01000000c3f4132e4200100063d04d280750656e616e7361f1426fe215c4b51c01000000ac7489c840150000470e4d440a57656e64792043686174000957656e64794368617400006a2753617690d65302000000f851ab0e000000008feb05009c2a42e7e22826677690d65302000000f851ab0e0000000091eb05005fb658c69d4d7df427df9a5b00000000eaa4ac5b0000000001f001ec1ba5ac5b23000000dc0000004042ae7415c4b51c01000000d904ba62f6a1199e00010000ea0f0000abcfe92432e5ddbd470e4d4410a5ac5b37738a4815c4b51c01000000abcfe924af1200000100000015c4b51c01000000c3f4132e42001000abcfe924065261796e617200f1426fe215c4b51c01000000ac7489c840150000470e4d440a57656e64792043686174000957656e64794368617400006a2753617690d65302000000f851ab0e000000008feb05009c2a42e7e22826677690d65302000000f851ab0e0000000091eb05005fb658c69d4d7df427df9a5b0000000010a5ac5b00000000';
        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/tg_app/update_new_channel_message');
        $this->assertEquals($got, $expected);
    }


    // instead of config_tg_app (expected_objects/get_config).
    public function test_schema_json_optional_arguments_using_flags_tg_app()
    {
        // bin2hex(pack("I", -1999999999)); = 016cca88
        // bin2hex(pack("I", 0b1101));      = 0d000000
        // bin2hex(pack("I", 666));         = 9a020000
        // bin2hex(pack("Q", 777));         = 0903000000000000
        // bin2hex(pack("I", 888));         = 78030000
        // bin2hex(pack("I", 1072550713));  = 39d3ed3f
        $data = '016cca880d0000009a020000090300000000000078030000';

        $got = $this->deserializeIntoComparableObject($data);
        $expected = file_get_contents(__DIR__ . '/expected_objects/tg_app/schema_json_optional_arguments_using_flags');

        $this->assertEquals($got, $expected);
    }
}